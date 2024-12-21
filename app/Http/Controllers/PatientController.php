<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

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
        //
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
}
