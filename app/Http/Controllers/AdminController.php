<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use Redirect;
use Auth;
use Session;
use Validator;
use Hash;

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

    public function CheckUserName(Request $request){
        $request->validate([
            'username' => 'required|string',
        ]);
    
        // Check if a patient exists with the given username
        $result = Patient::where('patient_login_id', $request->username)->exists();
    
        if ($result) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => 'This username is not available.',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'error' => false,
                'message' => 'This username is available.',
            ]);
        }
    }

    
    public function PatientSignup(Request $request)
{
    $validator = Validator::make($request->all(), [
        'fname' => 'required|string|max:255',
        'email' => 'required|email',
        'patient_login_id' => 'required|string|unique:patients,patient_login_id|max:255',
        'password' => 'required|string|min:8',
        'cpassword' => 'required|same:password',
    ], [], [
        // Custom attribute names
        'fname' => 'First Name',
        'lname' => 'Last Name',
        'email' => 'Email',
        'phone' => 'Phone Number',
        'patient_login_id' => 'User Name',
        'password' => 'Password',
        'cpassword' => 'Confirm Password',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    // Check if the email already exists
    $patient = Patient::where('email', $request->email)->first();
    if ($patient) {
        // Update existing patient
        $patient->fname = $request->fname;
        $patient->lname = $request->lname;
        $patient->phone = $request->phone;
        $patient->patient_login_id = $request->patient_login_id;
        $patient->password = Hash::make($request->password);
        $patient->save();

        return response()->json(['success' => true, 'message' => 'Patient details updated successfully!']);
    } else {
        // Create new patient
        $patient = new Patient();
        $patient->fname = $request->fname;
        $patient->lname = $request->lname;
        $patient->email = $request->email;
        $patient->phone = $request->phone;
        $patient->patient_login_id = $request->patient_login_id;
        $patient->password = Hash::make($request->password);
        $patient->save();

        return response()->json(['success' => true, 'message' => 'Signup successful!']);
    }
}


}

