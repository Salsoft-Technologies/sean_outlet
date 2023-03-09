<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FemaleDateLogsResource;
use App\Http\Resources\Admin\FemaleDetailResource;
use App\Http\Resources\Admin\FemaleListResource;
use App\Http\Resources\Admin\MaleDateLogsResource;
use App\Http\Resources\Admin\MaleDetailResource;
use App\Http\Resources\Admin\MaleListResource;
use App\Models\DateBooking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        $users = User::all();
        return apiJsonResponse(true, "", 200, [
            'total_users_count' => $users->count(),
            'male_counts' => $users->where('gender', User::MALE)->count(),
            'female_counts' => $users->where('gender', User::FEMALE)->count(),
        ]);
    }

    public function get_males_list(){
        return apiJsonResponse(true, "", 200, MaleListResource::collection(User::where('gender', User::MALE)->paginate(10)));
    }

    public function get_male_details(Request $request){
        return apiJsonResponse(true, "", 200, new MaleDetailResource(User::find($request->id)));
    }

    public function get_male_date_logs(Request $request){
        return apiJsonResponse(true, "", 200, MaleDateLogsResource::collection(
            DateBooking::where('male_id', $request->id)->paginate(10)
        ));
    }
    
    public function get_females_list(){
        return apiJsonResponse(true, "", 200, FemaleListResource::collection(User::where('gender', User::FEMALE)->paginate(10)));
    }

    public function get_female_details(Request $request){
        return apiJsonResponse(true, "", 200, new FemaleDetailResource(User::find($request->id)));
    }

    public function get_female_date_logs(Request $request){
        return apiJsonResponse(true, "", 200, FemaleDateLogsResource::collection(
            DateBooking::where('female_id', $request->id)->paginate(10)
        ));
    }
}
