<?php

namespace App\Http\Controllers\Api\Profile;

use App\Models\User;
use App\Models\Bank;
use App\Models\BankDetail;
use App\Models\ReportUser;
use App\Models\TimeSlot;
use App\Models\DateRequest;
use App\Models\DateBooking;
use App\Notifications\DateRequestAccepted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TimeSlotResource;
use App\Http\Resources\MaleProfileResource;
use App\Http\Resources\MaleRequestsResource;
use App\Http\Requests\BankDetailRequest;
use App\Http\Requests\TimeSlotRequest;
use App\Http\Requests\ReportUserRequest;
use App\Http\Controllers\Controller;

class FemaleProfileController extends Controller
{
    public function banks(){
        $banks = Bank::all();
        return apiJsonResponse(true, "", 200, $banks);
    }

    public function male_profile(Request $request){
        $user = User::where('id', $request->id)->where('gender', User::MALE)->first();
        if ($user) return apiJsonResponse(true, "", 200, new MaleProfileResource($user));
        else return apiJsonResponse(false, 'user not found');
    }

    public function bank_details(){
        $bank_details = BankDetail::find(Auth::id());
        return apiJsonResponse(true, "", 200, $bank_details);
    }

    public function edit_bank_details(BankDetailRequest $request){
        BankDetail::find(Auth::id())->update($request->all());
        return apiJsonResponse(true, "Bank details have been updated successfully.");
    }

    public function time_slots(){
        $time_slots = TimeSlot::where('user_id', Auth::id())->get();
        return apiJsonResponse(true, "", 200, TimeSlotResource::collection($time_slots));
    }

    public function add_time_slots(TimeSlotRequest $request){
        $request->merge(['user_id' => Auth::id()]);
        $time_slot = TimeSlot::create($request->all());

        return apiJsonResponse(true, "New time slot has been added.");
    }

    public function edit_time_slots(TimeSlotRequest $request){
        TimeSlot::find($request->id)->update([
            'date' => $request->date,
            'from' => $request->from,
            'to' => $request->to,
            'status' => $request->status,
        ]);

        return apiJsonResponse(true, "Time slot has been updated.");
    }

    public function male_requests(Request $request){
        $date_requests = DateRequest::where('status', $request->status)->where('female_id', Auth::id())->get();
        return apiJsonResponse(true, "", 200, MaleRequestsResource::collection($date_requests));
    }
    
    public function accept_request(Request $request){
        $date_request = DateRequest::find($request->id);
        $date_request->update(['status' => DateRequest::ACCEPTED]);
        $date_request->slot_info->update(['status' => TimeSlot::INACTIVE]);

        // notify male user, date request accepted, he can pay now
        $male = User::find($date_request->male_id);
        $male->notify(new DateRequestAccepted(Auth::user(), $date_request));

        return apiJsonResponse(true, "You have accepted request.");
    }

    public function reject_request(Request $request){
        DateRequest::find($request->id)->update([
            'status' => DateRequest::REJECTED,
        ]);

        return apiJsonResponse(true, "You have rejected request.");
    }

    public function report_user(ReportUserRequest $request){
        $report = ReportUser::create($request->all());
        return apiJsonResponse(true, "Your report will be reviewed soon.");
    }
}