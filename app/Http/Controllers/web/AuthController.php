<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
 public function index ():View{

    $title =__("pages.landing.page-title");
    return view('pages.welcome',compact('title'));
 }
 public function noAccessPage():View{
    $title =__("pages.no-access.page-title");
    return view('pages.noAccess',compact('title'));
 }
 public function maintenanceModePage():View{
    $title =__("pages.maintenance-mode.page-title");
    return view('pages.maintenance-mode',compact('title'));
 }
 public function showLoginPage():View{
    $title =__("pages.login.page-title");
    return view('pages.login',compact('title'));
 }
 public function showRegisterPage()
 {

    $title =__("pages.register.page-title");
     return view('pages.register',compact('title'));
 }
 public function showForgetPasswordPage()
 {
    $title =__("pages.forget-password.page-title");
     return view('pages.forgetPassword',compact('title'));
 }
 public function changePasswordPage()
 {
    $title =__("pages.change-password.page-title");
     return view('pages.changePassword',compact('title'));
 }


 public function logout(Request $request)
{

    Auth::logout(); // Log the user out
    $request->session()->invalidate(); // Invalidate the session
    $request->session()->regenerateToken(); // Regenerate the CSRF token

    // Optionally, you can redirect the user to a specific page after logout
    return redirect('/');
}
}


