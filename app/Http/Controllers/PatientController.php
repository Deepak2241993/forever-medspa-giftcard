<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\TransactionHistory;
use App\Models\Giftsend;
use App\Models\GiftcardsNumbers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\TimelineEvent;
use Auth;
use Carbon\Carbon;

use DB;
use Session;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Patient::where('is_deleted',0)->orderBy('id', 'DESC')->get();
    
        return view('admin.patient.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.patient.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient,Request $request)
    {
        // $timeline = TimelineEvent::where('patient_id',$patient->patient_login_id)->orderBy('created_at','DESC')->get();

        $query = TimelineEvent::query();

        // Apply filter if start_time and end_time are provided
        if ($request->start_time && $request->end_time) {
            $startTime = Carbon::parse($request->start_time)->startOfDay();
            $endTime = Carbon::parse($request->end_time)->endOfDay();
            $query->whereBetween('created_at', [$startTime, $endTime]);
        } else {
            // Show latest 10 entries by default
            $query->latest()->limit(10);
        }
    
        $timeline = $query->get();
        return view('admin.patient.create',compact('patient','timeline'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        try {
            // Update patient fields
            $patient->fname = $request->fname;
            $patient->lname = $request->input('lname', $patient->lname); // Optional field
            $patient->email = $request->email;
            $patient->phone = $request->phone;
            $patient->address = $request->input('address', $patient->address);
            $patient->city = $request->input('city', $patient->city);
            $patient->country = $request->input('country', $patient->country);
            $patient->zip_code = $request->input('zip_code', $patient->zip_code);

            // Update password if provided
            if ($request->filled('password')) {
                $patient->password = Hash::make($request->password);
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete the old image if exists
                if ($patient->image && Storage::exists('public/patient_images/' . $patient->image)) {
                    Storage::delete('public/patient_images/' . $patient->image);
                }

                // Store the new image
                $imagePath = $request->file('image')->store('public/patient_images');
                $patient->image = url('/').Storage::url($imagePath);
            }

            // Save the updated patient record
            $patient->save();

            return redirect()->back()->with('success', 'Patient details updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        //
    }

    public function PatientSearch(Request $request, Patient $patient)
            {
                // Start with a base query
                $query = $patient->query();

                // Apply filters if present in the request
                if ($request->filled('fname')) {
                    $query->whereRaw('LOWER(fname) LIKE ?', ['%' . strtolower($request->fname) . '%']);
                }

                if ($request->filled('lname')) {
                    $query->whereRaw('LOWER(lname) LIKE ?', ['%' . strtolower($request->lname) . '%']);
                }

                if ($request->filled('email')) {
                    $query->whereRaw('LOWER(email) LIKE ?', ['%' . strtolower($request->email) . '%']);
                }
                if ($request->filled('phone')) {
                    $query->whereRaw('LOWER(phone) LIKE ?', ['%' . strtolower($request->phone) . '%']);
                }

                // Order and paginate results
                $data = $query->orderBy('id', 'DESC')->paginate(10);

                // Return response as JSON
                return response()->json([
                    'status' => 'success',
                    'message' => 'Search results retrieved successfully.',
                    'data' => $data,
                ], 200);
            }

        //  For Dashboard
        public function PatientDashboard()
        {
            if (Auth::guard('patient')->check()) {
                $patient_login_id = Auth::guard('patient')->user()->patient_login_id;
                $order = TransactionHistory::where('patient_login_id',  $patient_login_id)->count();

                $giftcards = Giftsend::where(function($query) use ($patient_login_id) {
                    $query->whereColumn('gift_send_to', 'receipt_email')
                          ->where('recipient_name', null)
                          ->where('gift_send_to', $patient_login_id);
                })
                ->orWhere(function($query) use ($patient_login_id) {
                    $query->whereColumn('gift_send_to', '!=', 'receipt_email')
                          ->whereNotNull('recipient_name')
                          ->where('gift_send_to', $patient_login_id);
                })
                ->orderBy('id', 'DESC')
                ->count();
                return view('patient.patient_dashboad', compact('order','giftcards'));                
            }
            return redirect()->route('patient-login')->withErrors(['patient_login_id' => 'Please log in first.']);
        }
        // PAtient Profile
        public function PatientProfile(Patient $patient,Request $request)
        {
            $id = Auth::guard('patient')->user()->id;
            $patient = Patient::find($id);
            // dd($patient->patient_login_id);
            $query = TimelineEvent::query();

        // Apply filter if start_time and end_time are provided
        if ($request->start_time && $request->end_time) {
            $startTime = Carbon::parse($request->start_time)->startOfDay();
            $endTime = Carbon::parse($request->end_time)->endOfDay();
            $query->whereBetween('created_at', [$startTime, $endTime]);
        } else {
            // Show latest 10 entries by default
            $query->latest()->limit(10);
        }
    
        $timeline = $query->get();
            return view('patient.patient_profile.profile',compact('patient','timeline'));
        }

        //  For purchased Gift cards Show
         public function Mygiftcards(Patient $patient)
         {
            $patient_login_id = Auth::guard('patient')->user()->patient_login_id ;
            
            $mygiftcards = Giftsend::where(function($query) use ($patient_login_id) {
                $query->whereColumn('gift_send_to', 'receipt_email')
                      ->where('recipient_name', null)
                      ->where('gift_send_to', $patient_login_id);
            })
            ->orWhere(function($query) use ($patient_login_id) {
                $query->whereColumn('gift_send_to', '!=', 'receipt_email')
                      ->whereNotNull('recipient_name')
                      ->where('gift_send_to', $patient_login_id);
            })
            ->orderBy('id', 'DESC')
            ->paginate(10);

            $sendgiftcards = Giftsend::where('recipient_name','!=',null)->where('receipt_email',$patient_login_id)->orderBy('id','DESC')->paginate(10);

            return view('patient.giftcards.my-giftcards',compact('mygiftcards','sendgiftcards'));
         }

        //   Fro GiftcardRedeem View Page
        public function GiftcardsStatement(Request $request,Patient $patient,$id,GiftcardsNumbers $numbers)
        {
            $giftcards = GiftcardsNumbers::where('user_id', $id)
            ->orderBy('id', 'DESC')
            ->get();
            $token ='FOREVER-MEDSPA';
        //  For Statement of Giftcard
            $data=$numbers->select('giftcards_numbers.transaction_id','giftcards_numbers.user_token','giftcards_numbers.giftnumber','giftcards_numbers.amount','giftcards_numbers.comments','giftcards_numbers.actual_paid_amount','giftcards_numbers.updated_at')->Where('giftnumber',$giftcards[0]['giftnumber'])->where('user_token',$token)->get();
            $totalAmount = 0;
            $actual_paid_amount = 0;
        
            // Iterate over each record in the collection and sum up the 'amount' values
            foreach ($data as $record) {
                $totalAmount += $record->amount;
                $actual_paid_amount += $record->actual_paid_amount;
            }
        
            return view('patient.giftcards.redeem_statement',compact('giftcards','data','totalAmount','actual_paid_amount'));
        }

        // My Services
       public function Myservices(TransactionHistory $transaction){
        $email = Auth::guard('patient')->user()->email;
        $data = $transaction->where('email',$email)->orderBy('id','DESC')->paginate(10);
        return view('patient.services.my-services',compact('data'));
       }

    //     For Showing Invoice
    public function Patientinvoice($transaction_data) {
        try {
            $id = decrypt($transaction_data);           
            $transaction_data = TransactionHistory::findOrFail($id);
            return view('patient.patient-invoice', compact('transaction_data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid Invoice Link');
        }
    }
    
    public function storeAmount(Request $request)
    {
        $request->validate(['amount' => 'required|numeric']);
        Session::put('amount', $request->amount);

        // Check if the patient is logged in
        if (Auth::guard('patient')->check()) {
            return response()->json(['logged_in' => true]);
        } else {
            return response()->json(['logged_in' => false]);
        }
    }

    public function removeAmount(Request $request)
    {
        // Remove 'amount' from session
        $request->session()->forget('amount');

        // Optionally, redirect to a page (e.g., dashboard or home) after removal
        return redirect()->route('home')->with('success', 'Amount has been removed.');
    }
    public function emailSuggestions(Request $request)
    {
        $query = $request->input('query');

        $emails = Patient::where('email', 'LIKE', "%{$query}%")
                    ->pluck('email'); // Get only emails

        return response()->json($emails);
    }

    public function nameSuggestions(Request $request)
    {
        $query = $request->input('query');
        $patients = Patient::where('fname', 'LIKE', "%{$query}%")
        ->orWhere('lname', 'LIKE', "%{$query}%")
        ->selectRaw("CASE 
                        WHEN lname IS NULL OR lname = '' THEN fname
                        ELSE CONCAT(fname, ' ', lname) 
                     END as full_name")
        ->get();
    
        return response()->json($patients);
    
    }

    //  For Collect Patient Data
    // PatientData method in your controller
public function PatientData(Request $request)
{
    // Find patient by email
    $patientData = Patient::where('email', $request->email_id)->first();
    // dd($patientData);
    if (!$patientData) {
        return response()->json([
            'status' => 'error',
            'message' => 'Patient not found.',
        ], 404);
    }

    // Retrieve user giftcard Transaction Id for user
    $mygiftcards = Giftsend::where(function($query) use ($patientData) {
            $query->whereColumn('gift_send_to', 'receipt_email')
                  ->whereNull('recipient_name')
                  ->where('gift_send_to', $patientData->patient_login_id);
        })
        ->orWhere(function($query) use ($patientData) {
            $query->whereColumn('gift_send_to', '!=', 'receipt_email')
                  ->whereNotNull('recipient_name')
                  ->where('gift_send_to', $patientData->patient_login_id);
        })
        ->orderBy('id', 'DESC')
        ->get();
        $formattedGiftcards = [];

        foreach ($mygiftcards as $value) {
            // Get all gift card numbers for this transaction
            $giftcards = GiftcardsNumbers::where('transaction_id', $value->transaction_id)->pluck('giftnumber')->toArray();
        
            if (!empty($giftcards)) {
                // Get unique final results based on gift card numbers
                $final_results = GiftcardsNumbers::select(
                    'giftnumber as card_number',
                    DB::raw('SUM(actual_paid_amount) as total_paid_amount'),
                    DB::raw('SUM(amount) as total_value_amount')
                )
                ->whereIn('giftnumber', $giftcards) 
                ->where('user_token', 'FOREVER-MEDSPA')
                ->where('status', 1)
                ->groupBy('giftnumber')
                ->get();
        
                // Store unique gift cards
                foreach ($final_results as $result) {
                    $formattedGiftcards[$result->card_number] = [
                        'card_number' => $result->card_number,
                        'value_amount' => $result->total_value_amount,
                        'actual_paid_amount' => $result->total_paid_amount ?? 'N/A',
                    ];
                }
            }
        }
        
        // Convert associative array to indexed array
        $formattedGiftcards = array_values($formattedGiftcards);
        
        // dd($patientData);
    // Prepare JSON response
    return response()->json([
        'status' => 'success',
        'message' => 'Patient data and gift cards retrieved successfully.',
        'patient_data' => [
            'fname' => $patientData->fname,
            'lname' => $patientData->lname,
            'email' => $patientData->email,
            'phone' => $patientData->phone,
            'id' => $patientData->id,
        ],
        'giftcards' => $formattedGiftcards,
    ]);
}

    

}
