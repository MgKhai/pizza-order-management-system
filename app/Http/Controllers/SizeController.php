<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SizeController extends Controller
{
    // pizza size list page
    public function listPage(){
        $pizzaSizes = Size::select('*')->orderBy('created_at','desc')->paginate(5);
        return view('admin.size.list',compact('pizzaSizes'));
    }

    // pizza size create
    public function create(Request $request){

        $this->checkSizeValidation($request);
        $sizeData = $this->getSizeData($request);

        Size::create($sizeData);
        Alert::success('Success Title','Pizza Size Created Successfully');
        return back();
    }

    // pizza size edit page
    public function editPage($id){
        $editSize = Size::find($id);
        return view('admin.size.edit',compact('editSize'));
    }

    // pizza size update
    public function update(Request $request){
        $this->checkSizeValidation($request);
        $editSizeData = $this->getSizeData($request);

        Size::where('id',$request->id)->update($editSizeData);
        Alert::success('Success Title','Pizza Size Updated Successfully');
        return to_route('size#listPage');
    }

    // pizza size delete
    public function delete($id){
        Size::where('id',$id)->delete();
        return to_route('size#listPage');
    }

    //pizza size check validation
    private function checkSizeValidation($request){
        $request->validate([
            'pizzaSize' => 'required|min:2|max:50|unique:sizes,size,'.$request->id,
            'price' => 'required|numeric|max:99999'
        ]);
    }

    private function getSizeData($request){
        return [
            'size' => $request->pizzaSize,
            'price' => $request->price
        ];
    }
}
