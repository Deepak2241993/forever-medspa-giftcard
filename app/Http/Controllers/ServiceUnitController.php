<?php

namespace App\Http\Controllers;

use App\Models\ServiceUnit;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
class ServiceUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = ServiceUnit::where('product_is_deleted',0)->orderBy('id','DESC')->paginate(10);
        // dd($result);
        return view('admin.service_unit.service_unit_index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service_unit.service_unit_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,ServiceUnit $serviceUnit)
    {
        $token = Auth::user()->user_token;

    // Retrieve all request data except '_token'
    $data = $request->except('_token');

    // Add the user's token to the data
    $data['user_token'] = $token;
        $product_image = array();

        if ($request->hasFile('product_image')) {
            $folder = str_replace(" ", "_", $token);
            $destinationPath = '/uploads/' . $folder . "/";
        
            foreach ($request->file('product_image') as $image) {
                $filename = $image->getClientOriginalName();
                $image->move(public_path($destinationPath), $filename);
                array_push($product_image, url('/') . $destinationPath . $filename);
            }
            $finalImageUrl = implode('|',$product_image);
            $data['product_image'] = $finalImageUrl;
        }
        $serviceUnit->create($data);
        return redirect('/admin/unit')->with('message', 'Unit Added Successfully');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceUnit  $serviceUnit
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceUnit $serviceUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceUnit  $serviceUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceUnit $serviceUnit,$id)
    {
       $data = ServiceUnit::find($id);
        return view('admin.service_unit.service_unit_create',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceUnit  $serviceUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceUnit $serviceUnit)
{
    // Check if the service unit exists
    if (!$serviceUnit) {
        return redirect()->back()->with('error', 'Service unit not found.');
    }

    // Get the authenticated user's token
    $token = Auth::user()->user_token;

    // Prepare the data to update, excluding '_token' and '_method' fields
    $updateData = $request->except('_token', '_method');
    $updateData['user_token'] = $token;

    // Handle product images if any are uploaded
    $product_image = [];
    if ($request->hasFile('product_image')) {
        $folder = str_replace(" ", "_", $token);
        $destinationPath = '/uploads/' . $folder . "/";

        foreach ($request->file('product_image') as $image) {
            $filename = $image->getClientOriginalName();
            $image->move(public_path($destinationPath), $filename);
            $product_image[] = url('/') . $destinationPath . $filename;
        }

        $finalImageUrl = implode('|', $product_image);
        $updateData['product_image'] = $finalImageUrl;
    }
    // dd($updateData);
    // Update the service unit with the prepared data
    $data = ServiceUnit::find($request->id);
    $data->update($updateData);

    // Redirect back to the admin unit page with a success message
    return redirect('/admin/unit')->with('message', 'Unit is updated successfully');
}

    

    
    public function destroy(Request $request,ServiceUnit $serviceUnit)
    {
        $data = ServiceUnit::find($request->id);
        $data->update(['product_is_deleted'=>1]);
        return back()->with('message', 'Unit is Deleted Successfully');
    }

    // For Frontend Unit page Show

    public function UnitPageShow(Request $request, $id){
       $product = Product::find($id);
       $result = explode('|',$product->unit_id);
    //    dd($result);
        return view('product.unit_show',compact('result','product'));
    }

    public function UnitPageDetails(Request $request, $slug){
        $unit = ServiceUnit::where('product_slug',$slug)->first();
        $image = explode('|',$unit->product_image);
        
         // Fetch the term description if a unit was found
         if ($unit) {
            // Search for a term where `unit_id` includes the product's ID
            $term = DB::table('terms')
            ->where('status', 1)
            ->whereRaw("FIND_IN_SET(?, REPLACE(service_id, '|', ','))", [$unit->id])
            ->first();

            // Display the description
            $description = $term->description ?? 'No description available';
            $terms_id = $term->id ?? 'No id';
            }
            $unit['terms_and_conditions'] = $description;
            $unit['terms_id'] = $terms_id;
     //    dd($result);
         return view('product.unit_details',compact('unit','image'));
     }
}