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
        if(Session::has('result'))
        {
            return redirect(route('patient-dashboard'));
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

    public function PatientLoginPost(Request $request)
{
    $request->validate([
        'patient_login_id'=>'required',
        'password'=>'required|min:8'
    ],[
        'patient_login_id.required' => 'The username field is required.',
    ]);

    $credentials = $request->only('patient_login_id', 'password');
    $remember = $request->filled('remember'); 
   
    if (Auth::guard('patient')->attempt($credentials)) {
        if ($remember) {
            cookie()->queue('username', $request->patient_login_id, 43200); // 30 days
            cookie()->queue('password', $request->password, 43200); // 30 days
            cookie()->queue('remember', $request->remember, 43200); // 30 days
        } else {
            //  Clear cookies if 'Remember Me' is unchecked
            cookie()->queue(cookie()->forget('username'));
            cookie()->queue(cookie()->forget('password'));
            cookie()->queue(cookie()->forget('remember'));
        }
        // Store PAtient Details in Session
        $request->session()->put('patient_details', Auth::guard('patient')->user());
        // dd(Auth::guard('patient')->user());
        $request->session()->put('result.name', Auth::guard('patient')->user()->fname . ' ' . Auth::guard('patient')->user()->lname); // Store full name in session
        if (Session::has('amount')) {
            $amount = Session::get('amount');
            return redirect()->route('home')->with('amount', $amount);
        } else {
        return redirect()->route('patient-dashboard')->with('success', 'Login successful!');
        }
}
  // Return errors properly
  return back()->withErrors(['username' => 'Invalid credentials.'])->withInput();
}


    //  for PatientLogout

    public function Patientlogout(Request $request) {
        Auth::guard('patient')->logout();

    // Clear session data
        $request->session()->forget('result');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('patient-login'));
    }

    //    for User Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->forget('result');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
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
            'email' => 'required|email|max:255',
            'patient_login_id' => 'required|string|unique:patients,patient_login_id|max:255',
            'password' => 'required|string|min:8',
            'cpassword' => 'required|same:password',
        ], [], [
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
    
        $patient = Patient::where('email', $request->email)->first();
    
        if ($patient) {
            if (!$patient->patient_login_id && !$patient->password) {
                // Update existing patient with missing login details
                $patient->update([
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'phone' => $request->phone,
                    'patient_login_id' => $request->patient_login_id,
                    'password' => Hash::make($request->password),
                ]);
    
                return response()->json(['success' => true, 'message' => 'Patient details updated successfully!']);
            }
            return response()->json(['success' => false, 'errors' => ['email' => 'Email already exists. Please login.']], 422);
        }
    
        // Create a new patient
        Patient::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'patient_login_id' => $request->patient_login_id,
            'password' => Hash::make($request->password),
        ]);
    
        return response()->json(['success' => true, 'message' => 'Signup successful!']);
    }
    

}

