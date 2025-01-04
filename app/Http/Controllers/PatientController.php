<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Giftsend;
use App\Models\GiftcardsNumbers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Patient::
        paginate(10);
    
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
    public function edit(Patient $patient)
    {
        return view('admin.patient.create',compact('patient'));
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
        public function PatientDashboard(Patient $patient)
        {
            // Retrieve the currently authenticated patient's email
            // $patientEmail = Auth::guard('patient')->user()->email;
        
            // Find the patient data based on the email
            // $PatientData = Patient::where('email', $patientEmail)->first();
        
            // if (!$PatientData) {
            //     // Handle the case where the patient is not found
            //     abort(404, 'Patient not found.');
            // }
        
            // Count the number of gifts sent by the patient
            // $gift_buy = Giftsend::where('user_id', $PatientData->id)->count();
        
            // Return the dashboard view with the data
            return view('patient.patient_dashboad');
        }
       
        // PAtient Profile
        public function PatientProfile(Patient $patient)
        {
            $id = Auth::guard('patient')->user()->id;
            $patient = Patient::find($id);
            return view('patient.patient_profile.profile',compact('patient'));
        }

        //  For purchased Gift cards Show
         public function PurchasedGiftcards(Patient $patient)
         {
            $email = Auth::guard('patient')->user()->email;
            $giftcards = Giftsend::where('gift_send_to',$email)->orderBy('id','DESC')->paginate(10);
            return view('patient.giftcards.purchased_giftcards',compact('giftcards'));
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

        
        
}
