<?php

namespace App\Http\Controllers\Api\Auth;

use Exception;
use App\Models\User;
use App\Models\Role;
use App\Models\BankDetail;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function signup(SignupRequest $request){
        try{
            Log::debug('We are in Log Function');
            $request->merge(['password' => bcrypt($request->password)]);
            $request->merge(['avatar' => url('storage/default.png')]);
            $request->merge(['role_id' => Role::where('name', Role::USER)->first()->id]);
            $user = User::create($request->all());

            if($user->gender === User::FEMALE){
                $bankDetail = new BankDetail;
                $bankDetail->user_id = $user->id;
                $bankDetail->bank_id = $request->bank_id;
                $bankDetail->account_number = $request->account_number;
                $bankDetail->account_holder_name = $request->account_holder_name;
                $bankDetail->save();
            }
            return apiJsonResponse(true, 'registration successfull');
        }catch(Exception $e){
            Log::error($e->getMessage());
            return apiJsonResponse(false, $e->getMessage(), 500);            
        }
    }

    public function login(LoginRequest $request){
        try{
            Log::debug('We are in Log Function');
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                // after successfull login of user
                $user = Auth::user();
                $token = $user->createToken('main')->plainTextToken;
                return apiJsonResponse(true, 'login successfull', 200, [
                    'user' => $user,
                    'access_token' => $token,
                ]);
            }else{
                return apiJsonResponse(false, 'invalid email or password', 422);
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
            return apiJsonResponse(false, $e->getMessage(), 500);            
        }
    }

    public function logout(){
        try{
            Log::debug('We are in Log Function');
            $user = Auth::user();
            $user->currentAccessToken()->delete();
            return apiJsonResponse(true, 'logout successfull');
        }catch(Exception $e){
            Log::error($e->getMessage());
            return apiJsonResponse(false, $e->getMessage(), 500);            
        }
    }
}