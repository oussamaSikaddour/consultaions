<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
 public function index ():View{

    $title = "Landing Page";
    return view('pages.welcome',compact('title'));
 }
 public function noAccessPage():View{
    return view('pages.noAccess');
 }
 public function maintenanceModePage():View{
    return view('pages.maintenance-mode');
 }
 public function showLoginPage():View{
    return view('pages.login');
 }
 public function showRegisterPage()
 {
     return view('pages.register');
 }
 public function showForgetPasswordPage()
 {
     return view('pages.forgetPassword');
 }
 public function changePasswordPage()
 {
     return view('pages.changePassword');
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


