<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Size;
use App\Models\User;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Models\AddonItem;
use App\Models\ItemsCart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //user home page
    public function userHome( Request $request ){
        $categoryList = Category::select('id','name')->get(); //get category data for carousel
        $productList = Product::select('products.id as product_id','products.name as product_name','price','description','ingredients','stock','products.image as product_image','categories.id as category_id','categories.name as category_name')
                                    ->leftjoin('categories','products.category_id','categories.id')
                                    ->when( request('categoryId'), function($query){
                                        $query->where('products.category_id', request('categoryId'));
                                    })
                                    ->when( request('searchKey'), function($query){
                                        $query->whereAny(['products.name','categories.name'],'like','%'.request('searchKey').'%');
                                    })
                                    // min = true & max = true
                                    ->when( request('minPrice') != null && request('maxPrice') != null, function($query){
                                        $query->whereBetween('products.price',[request('minPrice'), request('maxPrice')]);
                                    })
                                    // min = true & max = false
                                    ->when( request('minPrice') != null && request('maxPrice') == null, function($query){
                                        $query->where('products.price','>=', request('minPrice'));
                                    })
                                    // min = false & max = true
                                    ->when( request('minPrice') == null && request('maxPrice') != null, function($query){
                                        $query->where('products.price','<=', request('maxPrice'));
                                    })
                                    ->when( request('sortingType'),function($query){
                                        $sortingRules = explode(',', request('sortingType'));
                                        $query->orderBy('products.'.$sortingRules[0], $sortingRules[1]);
                                    })
                                    ->get();

        // most order products
        $orderCounts = Order::select('products.category_id', 'orders.product_id', DB::raw('COUNT(*) as order_count'))
                                ->join('products', 'orders.product_id', '=', 'products.id')
                                ->groupBy('products.category_id', 'orders.product_id')
                                ->get();

        $topProductPerCategory = [];

        foreach ($orderCounts as $row) {
            $catId = $row->category_id;

            if (
                !isset($topProductPerCategory[$catId]) ||
                $row->order_count > $topProductPerCategory[$catId]['order_count']
                ) {
                    $topProductPerCategory[$catId] = [
                        'category_id' => $catId,
                        'product_id' => $row->product_id,
                        'order_count' => $row->order_count,
                    ];
                        }
            }


                    $mostOrderResults = collect($topProductPerCategory)
                                    ->map(fn($item) => [
                                        'category_id' => $item['category_id'],
                                        'product_id' => $item['product_id'],
                                    ])
                                    ->values();

        return view('user.main.list',compact('categoryList','productList','mostOrderResults'));
    }

    // product detail page
    public function productDetails($id){
        $productDetail = Product::select('products.id as product_id','products.name as product_name','price','description','ingredients','stock','products.image as product_image','categories.id as category_id','categories.name as category_name')
                                ->leftjoin('categories','products.category_id','categories.id')
                                ->where('products.id',$id)
                                ->first();

        // recommended product for customer
        $randomCategoryId = Category::where('id', '!=', $productDetail->category_id)
                                ->inRandomOrder()
                                ->value('id');

        $recommendProduct = Product::select('products.id as product_id','products.name as product_name','price','description','ingredients','stock','products.image as product_image','categories.id as category_id','categories.name as category_name')
                                ->rightjoin('categories','products.category_id','categories.id')
                                ->where('categories.id',$randomCategoryId)
                                ->get();

        // comment
        $comments = Comment::select('comments.id as comment_id','comments.product_id','comments.message','comments.created_at','users.id as user_id','users.name as user_name','users.profile as user_profile')
                                ->orderBy('comments.created_at','desc')
                                ->leftjoin('users','users.id','comments.user_id')
                                ->where('comments.product_id',$id)
                                ->get();

        // pizza size
        $pizzaSize = Size::select('*')
                                ->orderBy('price','asc')
                                ->get();

        // add on items
        $addOnItems = AddonItem::select('*')
                                ->get();

        // rating
        $rating = number_format(Rating::where('product_id',$id)->avg('count'));
        $userRating = number_format(Rating::where('product_id',$id)->where('user_id',Auth::user()->id)->value('count'));

        // most order products
        $orderCounts = Order::select('products.category_id', 'orders.product_id', DB::raw('COUNT(*) as order_count'))
                                ->join('products', 'orders.product_id', '=', 'products.id')
                                ->groupBy('products.category_id', 'orders.product_id')
                                ->get();

        $topProductPerCategory = [];

        foreach ($orderCounts as $row) {
            $catId = $row->category_id;

            if (
                !isset($topProductPerCategory[$catId]) ||
                $row->order_count > $topProductPerCategory[$catId]['order_count']
                ) {
                    $topProductPerCategory[$catId] = [
                        'category_id' => $catId,
                        'product_id' => $row->product_id,
                        'order_count' => $row->order_count,
                    ];
                        }
            }


                    $mostOrderResults = collect($topProductPerCategory)
                                    ->map(fn($item) => [
                                        'category_id' => $item['category_id'],
                                        'product_id' => $item['product_id'],
                                    ])
                                    ->values();

        return view('user.main.detail',compact('productDetail','randomCategoryId','recommendProduct','comments','rating','userRating','pizzaSize','addOnItems', 'mostOrderResults'));
    }

    // user comment
    public function comment(Request $request){
        Comment::create([
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id,
            'message' => $request->comment
        ]);

        Alert::success('Success Title','Comment Posted Succssfully');
        return back();
    }

    // user comment delete
    public function commentDelete($id){

        Comment::where('id',$id)->delete();
        return back();
    }

    // rating
    public function rating(Request $request){
        Rating::updateOrCreate([
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id
        ],[
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id,
            'count' => $request->productRating
        ]);

        Alert::success('Success','Rating Created Successfully');
        return back();
    }

    // user profile edit page
    public function profileEditPage(){
        return view('user.profile.edit');
    }

    // user profile update
    public function profileUpdate(Request $request){
        $this->checkProfileValidation($request);
        $profileData = $this->getProfileData($request);

        if($request->hasFile('image')){

            if( Auth::user()->profile != null ){

                if(file_exists( public_path('/profile/'.Auth::user()->profile) )){
                    unlink(public_path('/profile/'.Auth::user()->profile));
                }

            }

            $imageName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('/profile/'),$imageName);

            $profileData['profile'] = $imageName;

        }else{
            $profileData['profile'] = Auth::user()->profile;
        }

        User::where('id',Auth::user()->id)
                    ->update($profileData);

        Alert::success('Success Title','Profile Updated Successfully');
        return back();
    }

    // user password change page
    public function changePasswordPage(){
        return view('user.profile.changePassword');
    }

    //user password change
    public function changePassword(Request $request){
        if(Hash::check($request->oldPassword, Auth::user()->password)){
            $this->checkPasswordValidation($request);

            User::where('id',Auth::user()->id)
                    ->update([
                        'password' => Hash::make($request->newPassword)
                    ]);

            Alert::success('Success Title','Password Changed Successfully');
            return to_route('user#home');


        }else{
            Alert::error('Incorrect Password', 'It does not match with our records. Please try again!');
            return back();
        }
    }

    // user contact page
    public function contactPage(){
        return view('user.contact.contactForm');
    }

    // user contact
    public function contact(Request $request){
        $this->checkContactValidation($request);

        Contact::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'message' => $request->message
        ]);

        Alert::success('Success Title','Your Message Sent Successfully');
        return back();
    }

    // user cart page
    public function cartPage(){
        $cart = Cart::select('carts.id as cart_id','carts.qty','products.id as product_id','products.name as product_name','products.price','products.image as product_image','sizes.id as size_id','sizes.size as pizza_size','sizes.price as size_price','addon_items.id as addon_id','addon_items.name as addon_name','addon_items.price as addon_price')
                        ->leftjoin('products','carts.product_id','products.id')
                        ->leftjoin('sizes','carts.size_id','sizes.id')
                        ->leftJoin('items_carts', 'carts.id', 'items_carts.cart_id')
                        ->leftJoin('addon_items', 'items_carts.addon_item_id','addon_items.id')
                        ->where('carts.user_id', Auth::user()->id)
                        ->orderBy('carts.id','desc')
                        ->get();

        $groupCart = $cart->groupBy('cart_id');


        foreach($groupCart as $items){
            $addon_total = 0;
            foreach($items as $item){
                $addon_total += $item->addon_price;
            }
            foreach($items as $item){
                $item['addon_total'] = $addon_total;
            }

        }

        $total = 0;

        foreach($groupCart as $items){
            $total += ($items[0]->price + $items[0]->size_price + $items[0]->addon_total) * $items[0]->qty;

        }

        return view('user.main.cart',compact('groupCart','total'));
    }

    // add to cart process
    public function addToCart(Request $request){

        $cartData = [
           'user_id' => $request->userId,
            'product_id' => $request->productId,
            'size_id' => $request->pizza_size,
            'qty' => $request->qty
        ];

        if($request->extras){
            $cart = Cart::create($cartData);
            $cart->addOnItems()->attach($request->extras);

        }else{
            Cart::create($cartData);
        }

        Alert::success('Success Title','Add To Cart Created Successfully');
        return back();
    }

    // add to cart process with productId
    public function addToCartProductId($productId){

        $productData = Product::select('products.id as product_id','products.name as product_name','price','description','ingredients','stock','products.image as product_image','categories.id as category_id','categories.name as category_name')
                                    ->leftjoin('categories','products.category_id','categories.id')
                                    ->where('products.id',$productId)
                                    ->first();



        $smallestSize = Size::orderBy('price', 'asc')->select('id as size_id')->value('size_id');

        $Data = [
            'user_id' => Auth::user()->id,
             'product_id' => $productData->product_id,
             'qty' => 1
         ];

        if(Str::contains(Str::lower($productData->category_name), 'pizza')){
            $Data['size_id'] = $smallestSize;
        }

        Cart::create($Data);

        Alert::success('Success Title','Add To Cart Created Successfully');
        return back();
    }

    // cart delete
    public function cartDelete(Request $request){
        $cartId = $request['cartId'];

        ItemsCart::where('cart_id',$cartId)->delete();
        Cart::where('id',$cartId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'cart delete success'
        ],200);

    }

    //temporary storage
    public function tempStorage(Request $request)
    {
        $orderTemp = [];

        foreach($request->all() as $items)
        {
            $orderData = [
                'user_id' => $items['user_id'],
                'product_id' => $items['product_id'],
                'count' => $items['count'],
                'size_id' => $items['size_id'],
                'status' => $items['status'],
                'order_code' => $items['order_code'],
                'final_total' => $items['final_total'],
                'cart_id' => $items['cart_id']
            ];

            if (isset($items['addon_id']) && is_array($items['addon_id'])) {
                foreach ($items['addon_id'] as $addonId) {
                    $orderData['addon_id'][] = $addonId;
                }
            }

            $orderTemp[] = $orderData;
        }

        Session::put('tempCart',$orderTemp);

        return response()->json([
            'status' => 'success',
            'message' => 'temp storage store successfully'
        ], 200);
    }

    // user payment page
    public function paymentPage(){
        $paymentAcc = Payment::select('id','account_number','account_name','type')
                                    ->orderBy('type','asc')
                                    ->get();

        $tempOrder = Session::get('tempCart');

        return view('user.main.payment',compact('paymentAcc','tempOrder'));
    }

    // order
    public function order(Request $request){
        $request->validate([
            'name' => 'required|min:2|max:30',
            'phone' => 'required|digits:11',
            'address' => 'required|max:200',
            'paymentType' => 'required',
            'payslipImage' => 'required|file|mimes:png,jpg,jpeg,webp,svg,gif,avif',
        ]);

        $tempOrder = Session::get('tempCart');

        $paymentHistoryData = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->paymentType,
            'order_code' => $request->orderCode,
            'total_amt' => $request->totalAmount
        ];

        if($request->hasFile('payslipImage')){
            $imageName = uniqid().$request->file('payslipImage')->getClientOriginalName();
            $request->file('payslipImage')->move( public_path('/payslipImage/'),$imageName );
            $paymentHistoryData['payslip_image'] = $imageName;
        }

        PaymentHistory::create($paymentHistoryData);

        foreach( $tempOrder as $item ){
            $orderData = [
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'count' => $item['count'],
                'size_id' => $item['size_id'],
                'status' => $item['status'],
                'order_code' => $item['order_code']
            ];

            if(isset($item['addon_id'])){

                $order = Order::create($orderData);
                $order->addOnItems()->attach($item['addon_id']);

                // cart delete
                ItemsCart::where('cart_id',$item['cart_id'])->delete();
                Cart::where('user_id',$item['user_id'])->where('product_id',$item['product_id'])->delete();
            }else{
                Order::create($orderData);

                // cart delete
                Cart::where('user_id',$item['user_id'])->where('product_id',$item['product_id'])->delete();
            }
        }

        Alert::success('Thanks for your order!','Order Created Successfully');
        return to_route('user#home');
    }

    // order list page
    public function orderListPage(){
        $orderList = Order::where('user_id',Auth::user()->id)
                                ->groupBy('order_code')
                                ->orderBy('created_at','desc')
                                ->get();

        return view('user.main.orderList',compact('orderList'));
    }

    // order details
    public function orderDetails($orderCode){
        $order = Order::select('orders.id as order_id','orders.count','products.id as product_id','products.name as product_name','products.stock','products.price as product_price','products.image as product_image','sizes.id as size_id','sizes.size as pizza_size','sizes.price as size_price','addon_items.id as addon_id','addon_items.name as addon_name','addon_items.price as addon_price')
                        ->leftjoin('products','orders.product_id','products.id')
                        ->leftjoin('sizes','orders.size_id','sizes.id')
                        ->leftJoin('items_orders', 'orders.id', 'items_orders.order_id')
                        ->leftJoin('addon_items', 'items_orders.addon_item_id','addon_items.id')
                        ->where('orders.order_code', $orderCode)
                        ->get();

        $groupOrder = $order->groupBy('order_id');

        foreach ($groupOrder as $items) {
            $addon_total = 0;

            foreach ($items as $item) {
                $addon_total += $item->addon_price;
            }

            foreach ($items as $item) {
                $item->addon_total = $addon_total;
            }
        }

        return view('user.main.orderDetail',compact('groupOrder'));
    }


    // user profile check validation
    private function checkProfileValidation($request){
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email,'.Auth::user()->id,
            'phone' => 'required|digits:11',
            'address' => 'max:200',
            'image' => 'file|mimes:png,jpg,jpeg,webp,svg,gif,avif'
        ]);
    }

    // user profile get data
    private function getProfileData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
    }

    //  user profile password checkvalidation
    private function checkPasswordValidation($request){

        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|same:newPassword',
        ]);

    }

    // user contact form checkvalidation
    private function checkContactValidation($request){
        $request->validate([
            'title' => 'required|max:200',
            'message' => 'required|max:500'
        ]);
    }
}
