<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\Profile\MaleProfileController;
use App\Http\Controllers\Api\Profile\FemaleProfileController;
use App\Http\Controllers\Api\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    // auth routes
    Route::post('/login', 'login');
    Route::post('/signup', 'signup');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(ForgetPasswordController::class)->group(function () {
    // forget password
    Route::post('/forgot-password', 'forgot_password');
    Route::post('/verify-code', 'verify_code');
    Route::post('/set-password', 'set_password');
});

Route::middleware('auth:sanctum')->group(function () {
    // admin apis
    Route::controller(AdminController::class)->prefix('/admin')->group(function () {
        Route::get('/dashboard', 'dashboard');
        Route::get('/get-males', 'get_males_list');
        Route::get('/get-male-details', 'get_male_details');
        Route::get('/get-male-date-logs', 'get_male_date_logs');
        Route::get('/get-females', 'get_females_list');
        Route::get('/get-female-details', 'get_female_details');
        Route::get('/get-female-date-logs', 'get_female_date_logs');
        Route::get('/get-commission-rate', 'get_commission_rate');
        Route::post('/add-new-commission', 'add_new_commission');
        Route::post('/update-user-status', 'update_user_status');
        Route::get('/misconduct-report', 'misconduct_report');
        Route::get('/view-misconduct-report', 'view_misconduct_report');
        Route::get('/get-user-feedback', 'get_user_feedback');
        Route::get('/view-feedback-details', 'view_feedback_details');
        Route::get('/get-payment-logs', 'get_payment_logs');
        Route::get('/get-notifications', 'get_notifications');
        Route::get('/notification/{id}', 'read_notification');
    });
    // both male and female profile routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'profile');
        Route::get('/notifications-list', 'notifications_list');
        Route::get('/terms-condition', 'terms_condition');
        Route::get('/privacy-policy', 'privacy_policy');
        Route::get('/about', 'about');
        Route::post('/edit-profile', 'edit_profile');
        Route::post('/change-password', 'change_password');
        Route::post('/contact-us', 'contact_us');
    });
    // female profile routes
    Route::controller(FemaleProfileController::class)->group(function () {
        Route::get('/banks', 'banks');
        Route::get('/male-profile', 'male_profile');
        Route::get('/bank-details', 'bank_details');
        Route::get('/time-slots', 'time_slots');
        Route::get('/male-requests', 'male_requests');
        Route::post('/edit-bank-details', 'edit_bank_details');
        Route::post('/add-time-slots', 'add_time_slots');
        Route::post('/edit-time-slots', 'edit_time_slots');
        Route::post('/accept-request', 'accept_request');
        Route::post('/reject-request', 'reject_request');
        Route::post('/report-user', 'report_user');
    });
    // male profile routes
    Route::controller(MaleProfileController::class)->group(function () {
        Route::get('/female-list', 'female_list');
        Route::get('/female-profile', 'female_profile');
        Route::get('/booking-logs', 'booking_logs');
        Route::post('/request-now', 'request_now');
        Route::post('/book-date', 'book_date');
    });
});
