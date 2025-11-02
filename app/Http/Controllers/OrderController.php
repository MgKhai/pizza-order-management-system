<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ItemsOrder;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;

class OrderController extends Controller
{
    // admin order list review page
    public function orderListPage(){
        $orderList = Order::select('orders.id as order_id','orders.order_code','orders.status','orders.count','orders.created_at','users.name as user_name','products.stock',)
                                ->leftJoin('users','orders.user_id','users.id')
                                ->leftJoin('products','orders.product_id','products.id')
                                ->when(request('searchKey'), function($query){
                                    $query->whereAny([
                                        'orders.order_code',
                                        'users.name'
                                    ],'Like','%'.request('searchKey').'%');
                                })
                                ->where('orders.status','!=',1)
                                ->orderBy('orders.created_at','desc')
                                ->get();

        $groupOrder = $orderList->groupBy('order_code');

        foreach($groupOrder as $items){
            $stockCheck = true;
            foreach($items as $item){
                if($item->stock < $item->count){
                    $stockCheck = false;
                }
            }
            foreach($items as $item){
                $item['stock_check'] = $stockCheck;
            }

        }

        return view('admin.order.list',compact('groupOrder'));
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

        $stockCheck = true;
        foreach( $groupOrder as $items ){
            foreach( $items as $item ){
                if( $item->stock < $item->count ){
                    $stockCheck = false;
                    break;
                }
            }
        }

        $userProfileData = Order::select('users.id as user_id','users.name','users.phone as profile_phone','users.address as profile_address')
                                    ->leftJoin('users','orders.user_id','users.id')
                                    ->where('orders.order_code', $orderCode)
                                    ->first();


        $paymentInfo = PaymentHistory::select('payment_histories.*','payments.type')
                                        ->where('order_code',$orderCode)
                                        ->leftJoin('payments','payment_histories.payment_method','payments.id')
                                        ->first();

        return view('admin.order.detail',compact('groupOrder','paymentInfo','stockCheck','userProfileData'));
    }

    // order confirm
    public function orderConfirm(Request $request){

        Order::where('order_code',$request[0]['orderCode'])->update([
            'status' => 1
        ]);

        foreach($request->all() as $item){
            Product::where('id',$item['productId'])->decrement('stock', $item['productCount']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'order confirmed successfully'
        ], 200);
    }

    // order reject
    public function orderReject(Request $request){
        Order::where('order_code',$request['orderCode'])->update([
            'status' => 2
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'order rejected successfully'
        ], 200);
    }

    // order stautus change
    public function orderStatusChange(Request $request){
        Order::where('order_code',$request['orderCode'])->update([
            'status' => $request['status']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'status changed successfully'
        ], 200);
    }

    // order delete
    public function orderDelete($orderCode){
        $deleteOrderList = Order::select('id')->where('order_code',$orderCode)->get();

        foreach($deleteOrderList as $item){

            if(ItemsOrder::where('order_id', $item->id)->exists()){
                ItemsOrder::where('order_id',$item->id)->delete();
            }
            Order::where('id',$item->id)->delete();

        }

        $imageName = PaymentHistory::where('order_code',$orderCode)->value('payslip_image');

        if( file_exists(public_path('/payslipImage/'.$imageName))){ //delete image in the folder
            unlink(public_path('/payslipImage/'.$imageName));
        }

        PaymentHistory::where('order_code', $orderCode)->delete();
        return back();
    }

    // sales information page
    public function salesInfoPage(){
        $orderList = Order::select('orders.id as order_id','orders.order_code','orders.status','orders.count','orders.created_at','users.name as user_name','products.stock',)
                                ->leftJoin('users','orders.user_id','users.id')
                                ->leftJoin('products','orders.product_id','products.id')
                                ->when(request('searchKey'), function($query){
                                    $query->whereAny([
                                        'orders.order_code',
                                        'users.name'
                                    ],'Like','%'.request('searchKey').'%');
                                })
                                ->where('orders.status',1)
                                ->orderBy('orders.created_at','desc')
                                ->get();

        $groupOrder = $orderList->groupBy('order_code');

        foreach($groupOrder as $items){
            $stockCheck = true;
            foreach($items as $item){
                if($item->stock < $item->count){
                    $stockCheck = false;
                }
            }
            foreach($items as $item){
                $item['stock_check'] = $stockCheck;
            }

        }

        return view('admin.sales.info',compact('groupOrder'));
    }

    // sales info details
    public function salesInfoDetails($orderCode){
        $order = Order::select('orders.id as order_id','orders.count','products.id as product_id','products.name as product_name','products.stock','products.price as product_price','products.image as product_image','sizes.id as size_id','sizes.size as pizza_size','sizes.price as size_price','addon_items.id as addon_id','addon_items.name as addon_name','addon_items.price as addon_price','users.id as user_id','users.name','users.phone as profile_phone','users.address as profile_address')
                        ->leftjoin('products','orders.product_id','products.id')
                        ->leftjoin('sizes','orders.size_id','sizes.id')
                        ->leftJoin('items_orders', 'orders.id', 'items_orders.order_id')
                        ->leftJoin('addon_items', 'items_orders.addon_item_id','addon_items.id')
                        ->leftJoin('users','orders.user_id','users.id')
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

        $userProfileData = Order::select('users.id as user_id','users.name','users.phone as profile_phone','users.address as profile_address')
                                    ->leftJoin('users','orders.user_id','users.id')
                                    ->where('orders.order_code', $orderCode)
                                    ->first();



        $paymentInfo = PaymentHistory::select('payment_histories.*','payments.type')
                                        ->where('order_code',$orderCode)
                                        ->leftJoin('payments','payment_histories.payment_method','payments.id')
                                        ->first();

        return view('admin.sales.detail',compact('groupOrder','paymentInfo','userProfileData'));
    }


}
