<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    // payment list page
    public function listPage(){
        $paymentList = Payment::select('*')
                                ->orderBy('type')
                                ->paginate(6);

        return view('admin.payment.list',compact('paymentList'));
    }

    // payment create
    public function create(Request $request){

        $this->checkPaymentValidation($request);
        $accountData = $this->getData($request);

        Payment::create($accountData);
        Alert::success('Success Title','Payment Created Successfully');
        return back();
    }

    // payment delete
    public function delete($id){
        Payment::where('id',$id)->delete();
        return to_route('payment#listPage');
    }

    // payment edit page
    public function editPage($id){

        $editPayment = Payment::find($id);
        return view('admin.payment.edit',compact('editPayment'));
    }

    // payment update
    public function update(Request $request){

    $this->checkPaymentValidation($request);
    $editData = $this->getData($request);

    Payment::where('id',$request->id)
                    ->update($editData);
    Alert::success('Success Title','Payment Updated Successfully');
    return to_route('payment#listPage');
    }

    // payment check validation
    private function checkPaymentValidation($request){
        $request->validate([
            'accountNumber' => 'required|digits_between:11,20',
            'accountName' => 'required|string|min:2|max:255',
            'accountType' => 'required|min:2|unique:payments,type',
        ]);
    }

    // payment get data
    private function getData($request){
        return [
            'account_number' => $request->accountNumber,
            'account_name' => $request->accountName,
            'type' => $request->accountType
        ];
    }
}
