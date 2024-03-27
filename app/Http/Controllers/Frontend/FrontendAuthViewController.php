<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendAuthViewController extends Controller
{
    public function showLoginForm()
    {
        return view('allFrontendViews.auth.login');
    }
    public function showLoginNumberForm()
    {
        return view('allFrontendViews.auth.login_number');
    }
    public function showLogiOtpnForm()
    {
        return view('allFrontendViews.auth.login_otp');
    }
    public function showRegisterationForm(Request $request)
    {
        $invitee_id= (!empty($request->invitee_id) ? $request->invitee_id : '');
        return view('allFrontendViews.auth.register.signup', compact('invitee_id'));
    }
    public function showRegisterationOtpForm()
    {
        return view('allFrontendViews.auth.register.otp');
    }
    public function showRegisterationPasswordForm()
    {
        return view('allFrontendViews.auth.register.password');
    }
    public function showforgotForm()
    {
        return view('allFrontendViews.auth.passwords.forgot');
    }
    public function showResetOtpForm()
    {
        return view('allFrontendViews.auth.passwords.reset');
    }
    public function showResetPasswordForm()
    {
        return view('allFrontendViews.auth.register.password');
    }
 }