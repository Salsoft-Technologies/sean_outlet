<?php

namespace App\Http\Controllers\Api\Profile;

use App\Models\User;
use App\Models\TimeSlot;
use App\Models\DateRequest;
use App\Models\DateBooking;
use Illuminate\Http\Request;
use App\Notifications\NewDateRequest;
use App\Http\Resources\FemaleProfileResource;
use App\Http\Resources\BookingLogsResource;
use App\Http\Requests\RequestDateRequest;
use App\Http\Requests\DateBookingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MaleProfileController extends Controller
{
    public function female_list(){
        $females = User::where('gender', User::FEMALE)->get(['id','avatar','full_name','age']);
        return apiJsonResponse(true, "", 200, $females);
    }

    public function female_profile(Request $request){
        $user = User::where('id', $request->id)->where('gender', User::FEMALE)->first();
        if ($user) return apiJsonResponse(true, "", 200, new FemaleProfileResource($user));
        else return apiJsonResponse(false, "user not found");
    }

    public function request_now(RequestDateRequest $request){
        // check if time slot is available
        $requested_timeslot = TimeSlot::find($request->slot_id);
        if($requested_timeslot->status === TimeSlot::INACTIVE){
            return apiJsonResponse(false, "time slot not available");
        }
        $request->merge(['male_id' => Auth::id()]);
        $request->merge(['status' => DateRequest::PENDING]);
        $date_request = DateRequest::create($request->all());

        // notify female that a male user has requested a date
        $female = User::find($request->female_id);
        $female->notify(new NewDateRequest(Auth::user(), $date_request));

        return apiJsonResponse(true, "your request has been sent.");
    }

    public function book_date(DateBookingRequest $request){
        $female = User::find($request->female_id);
        $request->merge(['price' => $female->price]);
        $request->merge(['male_id' => Auth::id()]);
        $request->merge(['status' => DateBooking::UPCOMING]);
        $date_booking = DateBooking::create($request->all());

        return apiJsonResponse(true, "Your date has been scheduled.");
    }
    
    public function booking_logs(Request $request){
        $booking_logs = DateBooking::where('status', $request->status)->where('male_id', Auth::id())->get();
        return apiJsonResponse(true, "", 200, BookingLogsResource::collection($booking_logs));
    }
}