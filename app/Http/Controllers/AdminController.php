<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Redirect;
use Auth;
use Session;
use Validator;

class AdminController extends Controller
{
    public function login(){
        if(Auth::check())
        {
    
            return redirect(route('root'));
        }
        else
        {
            return view('auth.login');
        }
    }


    //  for patient login
    public function Patientlogin(){
        if(Auth::check())
        {
    
            return redirect(route('home'));
        }
        else
        {
            return view('auth.patient_login');
        }
    }

    //  for User Login
    public function login_post(Request $request){
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|alphaNum|min:8'
           ]);
      
           $credentials = $request->only('email', 'password');
      
           if(Auth::attempt($credentials))
           {
                $request->session()->put('result',Auth::user()->name);
                $response = array('success' => true, 'error' => false, 'message' => 'Login successfully..');
                return redirect(route('root'));
            }
        else{
            $response = array('success' => false, 'error' => true, 'message' => 'Please Check User Details');
            return redirect(route('login'));
             }
    }


    //  for Patienet Login Process
    public function PatientLoginPost(Request $request){
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|alphaNum|min:8'
        ]);
    
            // Extract email and password
            $credentials = $request->only('email', 'password');
            if (Auth::guard('patient')->attempt($credentials)) {
                $request->session()->put('result.name', Auth::guard('patient')->user()->fname . ' ' . Auth::guard('patient')->user()->lname); // Store full name in session

                $response = ['success' => true, 'error' => false, 'message' => 'Logged in as a Patient'];
                return redirect(route('patient-dashboard'))->with($response);
            }
            // If attempts fail
            $response = ['success' => false, 'error' => true, 'message' => 'Invalid login details.'];
            return redirect(route('patient-login'))->with($response);
    }

    //  for PatientLogout

    public function Patientlogout(Request $request) {
        Auth::logout();
        $request->session()->pull('result');
        return redirect(route('patient-login'));
    }

    //    for User Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->pull('result');
        return redirect('/login');
      }

    
}
