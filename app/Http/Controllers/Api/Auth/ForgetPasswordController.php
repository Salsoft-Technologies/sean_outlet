<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Mail\PasswordResetCodeMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ForgetPasswordController extends Controller
{
    public function forgot_password(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if($validator->fails()){
            return apiJsonResponse(false, $validator->errors()->first(), 422);
        }

        try{
            // Log::debug('We are in Log Function');
            $user = User::where('email', $request->email)->first();  
            DB::table('password_resets')->where('email', $request->email)->delete();
            $code = rand(100001, 999999);     
            $passwordReset = DB::table('password_resets')->updateOrInsert([
                'email' => $request->email,
            ],[
                'email' => $request->email,
                'token' => $code,
                'created_at' => Carbon::now(),
            ]);

            try{
                Mail::to($request->email)->send(new PasswordResetCodeMail($user, $code));
            }catch (\Exception $exception){
                // Log::error($exception->getMessage());
                return apiJsonResponse(false, $exception->getMessage(), 500); 
            }

            return apiJsonResponse(true, 'We have sent you a verification code');
            
        }catch(\Exception $e){
            // Log::error($e->getMessage());
            return apiJsonResponse(false, $e->getMessage(), 500);            
        }

        
    }

    public function verify_code(Request $request){
        try{
            // Log::debug('We are in Log Function');
            $code = DB::table('password_resets')->where('token', $request->code)->where('email', $request->email)->first();
            if($code){
                return apiJsonResponse(true, 'code has been verified successfully.');
            }else{
                return apiJsonResponse(false, 'Invalid code, please try again.', 422);
            }
        }catch(\Exception $e){
            // Log::error($e->getMessage());
            return apiJsonResponse(false, $e->getMessage(), 500);            
        } 
    }

    public function set_password(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'same:password',
        ]);
        if($validator->fails()){
            return apiJsonResponse(false, $validator->errors()->first(), 422);
        }

        try{
            // Log::debug('We are in Log Function');
            $code = DB::table('password_resets')->where('email',$request->email)->first();
            if(!$code){
                return apiJsonResponse(false, 'Email is invalid.', 409);
            }
            $user = User::whereEmail($request->email)->first();
            $user->password = bcrypt($request->password);
            $user->save();
            
            DB::table('password_resets')->where('token',$code->token)->where('email',$request->email)->delete();
            return apiJsonResponse(true, 'Password updated successfully.');
        }catch(\Exception $e){
            // Log::error($e->getMessage());
            return apiJsonResponse(false, $e->getMessage(), 500);            
        }        
    }
}