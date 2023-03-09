<?php

namespace App\Http\Controllers\Api\Profile;

use App\Models\User;
use App\Models\ContactUs;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ContactUsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile(){
        return apiJsonResponse(true, '', 200, new ProfileResource(Auth::user()));
    }

    public function edit_profile(EditProfileRequest $request){
        $request->merge(['gender' => Auth::user()->gender]);

        // upload profile picture if present
        if($request->hasFile('profile_image')){
            $image_path = uploadImage($request->file('profile_image'));
            $request->merge(['avatar' => $image_path]);
        }

        // upload user's all images if present
        if($request->hasFile('images')){
            $uploadImages = uploadManyImages($request->file('images'));
            if(!$uploadImages){
                return apiJsonResponse(false, 'Only jpg, png, jpeg extensions are allowed.', 422);
            }
        }

        $user = User::find(Auth::id())->update($request->all());
        return apiJsonResponse(true, 'profile updated successfully.');
    }

    public function change_password(ChangePasswordRequest $request){
        $user = User::findOrFail(Auth::id());
        if (Hash::check($request->current_password, $user->password)) { 
            $user->fill([
             'password' => Hash::make($request->new_password)
            ])->save();
         
            return apiJsonResponse(true, 'Password changed successfully.');
        }else{
            return apiJsonResponse(false, 'Passwords don\'t match.');
        }
    }

    public function notifications_list(){
        $user = User::find(Auth::id());
        return apiJsonResponse(true, '', 200, $user->notifications);
    }

    public function contact_us(ContactUsRequest $request){
        $contact = ContactUs::create($request->all());

        return apiJsonResponse(true, 'Your message has been sent.');
    }

    public function terms_condition(){
        return "<h1>Terms & Condition</h1>";
    }

    public function privacy_policy(){
        return "<h1>Privacy Policy</h1>";
    }

    public function about(){
        return "<h1>About Us</h1>";
    }
}