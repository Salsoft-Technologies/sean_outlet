<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\Commission;
use App\Models\DateBooking;
use App\Models\ReportUser;
use App\Models\UserFeedback;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FemaleDateLogsResource;
use App\Http\Resources\Admin\FemaleDetailResource;
use App\Http\Resources\Admin\FemaleListResource;
use App\Http\Resources\Admin\MaleDateLogsResource;
use App\Http\Resources\Admin\MaleDetailResource;
use App\Http\Resources\Admin\MaleListResource;
use App\Http\Resources\Admin\MisconductReportResource;
use App\Http\Resources\Admin\PaymentLogsResource;
use App\Http\Resources\Admin\UserFeedbackResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function update_user_status(Request $request){
        User::find($request->user_id)->update(['status' => $request->status]);
        return apiJsonResponse(true, "status updated successfully");
    }

    public function add_new_commission(Request $request){
        $validator = Validator::make($request->all(), [
            'commission_rate' => 'required',
            'effective_date' => 'required',
        ]);

        if($validator->fails()){
            return apiJsonResponse(false, $validator->errors()->first(), 422);
        }

        $current_rate = Commission::latest()->first();
        Commission::create([
            'old_commission' => $current_rate->new_commission ?? "",
            'new_commission' => $request->commission_rate,
            'effective_date' => $request->effective_date,
        ]);

        return apiJsonResponse(true, "new commission rate added");
    }

    public function get_commission_rate(){
        $rates = Commission::latest()->paginate(10);
        return apiJsonResponse(true, "", 200, $rates);
    }

    public function misconduct_report(){
        return apiJsonResponse(true, "", 200, MisconductReportResource::collection(ReportUser::paginate(10)));
    }

    public function view_misconduct_report(Request $request){
        $report = ReportUser::find($request->id);
        return apiJsonResponse(true, "", 200, [
            'user_id' => $report->male_id,
            'name' => $report->male_info->full_name,
            'reason' => $report->reason,
        ]);
    }

    public function get_user_feedback(){
        $feedback = UserFeedback::paginate(10);
        return apiJsonResponse(true, "", 200, UserFeedbackResource::collection($feedback));
    }

    public function view_feedback_details(Request $request){
        $feedback = UserFeedback::find($request->id);
        return apiJsonResponse(true, "", 200, [
            'user_id' => $feedback->user_id,
            'full_name' => $feedback->user->full_name,
            'user_name' => $feedback->user->user_name,
            'email' => $feedback->user->email,
            'avatar' => $feedback->user->avatar,
            'gender' => $feedback->user_type,
            'subject' => $feedback->subject,
            'message' => $feedback->message,
        ]);
    }

    public function get_payment_logs(){
        $date_bookings = DateBooking::latest()->paginate(10);
        $earning = DateBooking::sum('commission');
        return apiJsonResponse(true, "", 200, [
            'overall_earning' => $earning,
            'logs' => PaymentLogsResource::collection($date_bookings),
        ]);
    }

    public function get_notifications(){
        return apiJsonResponse(true, "", 200, Auth::user()->unreadNotifications);
    }

    public function read_notification($id){
        $userUnreadNotification = Auth::user()->unreadNotifications->where('id', $id)->first();
        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return apiJsonResponse(true, "marked as read");
        }
        return apiJsonResponse(false, "notification not found");
    }
}
