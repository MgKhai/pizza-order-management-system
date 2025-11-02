<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function adminDashboard(){
        $totalSaleAmt = PaymentHistory::sum('total_amt');
        $orderCount = Order::whereIn('status',[0,1])->count('id');
        $registerUserCount = User::where('role','user')->count('id');
        $pendingRequest = Order::where('status',0)->count('id');

        return view('admin.main.home',compact('totalSaleAmt','orderCount','registerUserCount','pendingRequest'));
    }

    // create new admin page
    public function createAdminPage(){
        return view('admin.account.newAdmin');
    }

    // create new admin
    public function createAdmin(Request $request){
        $this->checkAccountValidation($request);

        $newAdminData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ];

        User::create($newAdminData);

        Alert::success('Success Title','New Admin Account Created Successfully');
        return back();
    }

    // admin list page
    public function adminListPage(){
        $adminList = User::select('id','name','nickname','email','address','phone','role','created_at','provider','profile')
                            ->whereIn('role',['superadmin','admin'])
                            ->when( request('searchKey'),function($query){
                                $query->whereAny([
                                    'name',
                                    'email',
                                    'phone',
                                    'address',
                                    'role',
                                    'provider'
                                ],'like','%'.request('searchKey').'%');
                            })
                            ->paginate(4);

        return view('admin.account.adminList',compact('adminList'));
    }

    // admin list delete
    public function adminListDelete($id){
        $profileName = User::where('id',$id)->value('profile');

        if($profileName != null){

            if( file_exists(public_path('/profile/'.$profileName))){ //delete image in the folder
                unlink(public_path('/profile/'.$profileName));
            }
        }

        User::where('id', $id)->delete();
        return back();
    }

    // user list page
    public function userListPage(){

        $userList = User::select('id','name','nickname','email','address','phone','role','created_at','provider','profile')
                            ->where('role','user')
                            ->when( request('searchKey'), function($query){
                                $query->whereAny([
                                    'name',
                                    'nickname',
                                    'email',
                                    'address',
                                    'phone',
                                    'role',
                                    'provider'
                                ],'like','%'.request('searchKey').'%');
                            })
                            ->paginate(4);

        return view('admin.account.userList', compact('userList'));
    }

    // user list delete
    public function userListDelete($id){
        $profileName = User::where('id',$id)->value('profile');

        if($profileName != null){
            if(file_exists(public_path('/profile/'.$profileName))){
                unlink( public_path('/profile/'.$profileName));
            }
        }

        User::where('id',$id)->delete();
        return back();
    }

    // account check validation
    private function checkAccountValidation($request){
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => 'required|min:8',
            'confirmPassword' => 'required|same:password'
        ]);
    }
}
