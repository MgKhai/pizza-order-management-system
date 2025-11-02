<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    // category list page
    public function listPage(){
        $categories = Category::select('*')
                        ->orderBy('created_at','desc')
                        ->paginate(4);

        return view('admin.category.list',compact('categories'));
    }

    // category create
    public function create(Request $request){
        $this->checkvalidation($request);

        $data = $this->getData($request);
        Category::create($data);
        Alert::success('Success Title','Category Created Successfully');
        return back();
    }

    // category delete
    public function delete($id){
        Category::where('id',$id)->delete();
        return to_route('category#list');
    }

    // category edit page
    public function editPage($id){
        $editCategory = Category::find($id);
        return view('admin.category.edit',compact('editCategory'));
    }

    // category update
    public function update(Request $request){

        $this->checkvalidation($request);
        $data = $this->getData($request);

        Category::where('id',$request->id)->update($data);
        Alert::success('Success Title','Category Updated Successfully');
        return to_route('category#list');

    }

    // get category data
    private function getData($request){
        return [
            'name' => $request->categoryName,
        ];
    }

    // category validation check
    private function checkvalidation($request){
        $rules = [
            'categoryName' => 'required|min:3|max:50|unique:categories,name,'.$request->id
        ];
        $request->validate($rules);
    }

}
