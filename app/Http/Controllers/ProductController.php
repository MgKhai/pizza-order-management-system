<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    // product page
    public function createPage(){
        $categoryList = Category::select('id','name')
                                    ->get();

        return view('admin.product.create',compact('categoryList'));
    }

    // product create
    public function create(Request $request){
        $this->checkvalidation($request,'create');

        $data = $this->getData($request);

        if($request->hasFile('image')){
            $imageName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->move( public_path('/imageProduct/'),$imageName); // save image in public folder

            $data['image'] = $imageName;
        }

        Product::create($data);
        Alert::success('Success Title','Product Created Succssfully');
        return back();
    }

    // product list
    public function list($action = 'default'){
        $products = Product::select('products.id as product_id','products.name as product_name','products.price','products.description','products.ingredients','category_id','categories.name as category_name','stock','products.image as product_image')
                        ->when( $action == 'lowAmt' , function($query){
                            $query->where('stock','<=',3);
                        } )
                        ->when( request('searchKey'), function($query){
                            $query->whereAny([
                                'products.name',
                                'categories.name',
                            ],
                                'like','%'.request('searchKey').'%'
                            );
                        })
                        ->leftjoin('categories','products.category_id','categories.id')
                        ->orderBy('products.created_at','desc')
                        ->paginate(4);

        return view('admin.product.list',compact('products'));
    }

    // product edit page
    public function editPage($id){
        $editProduct = Product::select('products.id as product_id','products.name as product_name','products.price','products.description','products.ingredients','category_id','categories.name as category_name','stock','products.image as product_image')
                        ->leftjoin('categories','products.category_id','categories.id')
                        ->find($id);

        $categoryList = Category::select('id','name')
                            ->get();

        return view('admin.product.edit',compact('editProduct','categoryList'));
    }

    // product update
    public function update(Request $request){

        $this->checkvalidation($request,'update');
        $data = $this->getData($request);


        if($request->hasFile('image')){
            if(file_exists(public_path('/imageProduct/'.$request->oldImage))){
                unlink(public_path('/imageProduct/'.$request->oldImage));
            }
            $imageName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->move( public_path('/imageProduct/'),$imageName); // save image in public folder

            $data['image'] = $imageName;
        }else{
            $data['image'] = $request->oldImage;
        }

        Product::where('id',$request->productId)
                    ->update($data);
        Alert::success('Success Title','Product Updated Successfully');

        return to_route('product#list');
    }

    // product delete
    public function delete($id){
        $imageName = Product::where('id',$id)->value('image');

        if( file_exists(public_path('/imageProduct/'.$imageName))){ //delete image in the folder
            unlink(public_path('/imageProduct/'.$imageName));
        }

        product::where('id', $id)->delete();
        return to_route('product#list');
    }

    // product detail page
    public function detailPage($id){
        $detailProduct = Product::select('products.id as product_id','products.name as product_name','products.price','products.description','products.ingredients','category_id','categories.name as category_name','stock','products.image as product_image')
                        ->leftjoin('categories','products.category_id','categories.id')
                        ->find($id);
        return view('admin.product.detail',compact('detailProduct'));
    }

    // product checkvalidation
    private function checkvalidation($request,$action){
        $rules=[
            'name' => 'required|min:3|max:50|unique:products,name,'.$request->productId,
            'category' => 'required',
            'price' => 'required|numeric|max:99999',
            'stock' => 'required|numeric|max:99',
            'ingredients' => 'required|max:2000',
            'description' => 'required|max:2000'
        ];

        $rules['image'] = $action == 'create' ? 'required|file|mimes:png,jpg,jpeg,webp,svg,gif,avif' : 'file|mimes:png,jpg,jpeg,webp,svg,gif,avif';

        $request->validate($rules);
    }

    // product data
    private function getData($request){
        return [
            'name' => $request->name,
            'category_id' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'ingredients' => $request->ingredients,
            'description' => $request->description
        ];
    }

}
