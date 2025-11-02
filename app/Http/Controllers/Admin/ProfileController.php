<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    // profile change password page
    public function changePasswordPage(){
        return view('admin.profile.changePassword');
    }

    // profile change password
    public function changePassword(Request $request){

        if( Hash::check($request->oldPassword, Auth::user()->password) ){
            $this->checkPasswordValidation($request);

            User::where('id',Auth::user()->id)
                        ->update([
                            'password' => Hash::make($request->newPassword)
                        ]);

            Alert::success('Success Title', 'Password Changed Successfully');
            return back();

        }else{
            Alert::error('Incorrect Password', 'It does not match with our records. Please try again.');
            return back();
        }

    }

    // profile edit page
    public function editProfilePage(){
        return view('admin.profile.edit');
    }

    // profile edit
    public function updateProfile(Request $request){

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

    // profile password checkvalidation
    private function checkPasswordValidation($request){

        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|same:newPassword',
        ]);

    }

    // profile check validation
    private function checkProfileValidation($request){
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email,'.Auth::user()->id,
            'phone' => 'required|digits:11',
            'address' => 'max:200',
            'image' => 'file|mimes:png,jpg,jpeg,webp,svg,gif,avif'
        ]);
    }

    // profile get data
    private function getProfileData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
    }
}
