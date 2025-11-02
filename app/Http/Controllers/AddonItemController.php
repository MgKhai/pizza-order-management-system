<?php

namespace App\Http\Controllers;

use App\Models\AddonItem;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AddonItemController extends Controller
{
    // item list page
    public function listPage(){
        $itemList = AddonItem::select('*')->orderBy('created_at','desc')->paginate(5);
        return view('admin.item.list',compact('itemList'));
    }

    // item create
    public function create(Request $request){
        $this->checkItemValidation($request);
        $itemData = $this->getItemData($request);

        AddonItem::create($itemData);
        Alert::success('Success Title','Add-on Item Created Successfully');
        return back();
    }

    // item delete
    public function delete($id){

        AddonItem::where('id',$id)->delete();
        return to_route('item#listPage');
    }

    // item edit page
    public function editPage($id){
        $editItem = AddonItem::find($id);
        return view('admin.item.edit',compact('editItem'));
    }

    // item update
    public function update(Request $request){
        $this->checkItemValidation($request);
        $updateItem = $this->getItemData($request);

        AddonItem::where('id',$request->id)->update($updateItem);
        Alert::success('Success Title','Add-on Item Updated Successfully');

        return to_route('item#listPage');
    }

    // item check validation
    private function checkItemValidation($request){
        $request->validate([
            'name' => 'required|min:2|max:50|unique:addon_items,name,'.$request->id,
            'price' => 'required|numeric|max:99999'
        ]);
    }

    // item data
    private function getItemData($request){
        return [
            'name' => $request->name,
            'price' => $request->price
        ];
    }
}
