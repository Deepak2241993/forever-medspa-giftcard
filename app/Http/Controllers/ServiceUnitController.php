<?php

namespace App\Http\Controllers;

use App\Models\ServiceUnit;
use App\Models\Product;
use App\Models\Banner;
use App\Models\ProductCategory;
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
    $product_image = [];

    if ($request->hasFile('product_image')) {
        $folder = str_replace(" ", "_", $token);
        $destinationPath = '/uploads/' . $folder . "/";

        foreach ($request->file('product_image') as $image) {
            // Move the image to the destination path
            $filename = $image->getClientOriginalName();
            $image->move(public_path($destinationPath), $filename);

            // Store the image URL
            $product_image[] = url('/') . $destinationPath . $filename;
        }

        // Combine the image URLs into a single string
        $finalImageUrl = implode('|', $product_image);
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
            // Move the image to the destination path
            $filename = $image->getClientOriginalName();
            $image->move(public_path($destinationPath), $filename);

            // Store the image URL
            array_push($product_image,url('/') . $destinationPath . $filename);
        }
        // Combine the image URLs into a single string
        $finalImageUrl = implode('|', $product_image);
        $data['product_image'] = $finalImageUrl;
    }
    // dd($product_image);
    
    // Update the service unit with the prepared data
    $data = ServiceUnit::find($request->id);
    // dd($data);
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

    public function UnitPageShow(Request $request, $slug){
       $product = Product::where('product_slug',$slug)->first();
       $result = explode('|',$product->unit_id);
    //    dd($result);
        return view('product.unit_show',compact('result','product'));
    }

    public function UnitPageDetails(Request $request, $product_slug,$slug){
        $unit = ServiceUnit::where('product_slug',$slug)->first();
        $image = explode('|',$unit->product_image);
         // Fetch the term description if a unit was found
         if ($unit) {
            // Search for a term where `unit_id` includes the product's ID
            $term = DB::table('terms')
            ->where('status', 1)
            ->whereRaw("FIND_IN_SET(?, REPLACE(unit_id, '|', ','))", [$unit->id])
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

     //  For Showing All Service And Unit on Same Page
public function ServicePage(Request $request){

    $sliders =Banner::where('status',1)->where('is_deleted',0)->orderBy('id','DESC')->get();
    // $category_result=ProductCategory::where('cat_is_deleted','=',0)->where('status','=',1)->where('user_token','FOREVER-MEDSPA')->get();        
    //     $data = Product::where('status', '=', 1)
    //     ->where('product_is_deleted', '=', 0)
    //     ->where(function ($query) use ($id) {
    //         $query->where('cat_id', 'LIKE', '%|' . $id . '|%')
    //               ->orWhere('cat_id', 'LIKE', $id . '|%')
    //               ->orWhere('cat_id', 'LIKE', '%|' . $id)
    //               ->orWhere('cat_id', $id);
    //     })
    //     ->paginate(20);
    

        $data = Product::where('product_is_deleted','=',0)->where('status','=',1)->paginate(10);
        $category=ProductCategory::where('cat_is_deleted','=',0)->where('status','=',1)->where('user_token','FOREVER-MEDSPA')->orderBy('id','DESC')->get();
        $popular_service=Product::where('popular_service',1)->where('product_is_deleted','=',0)->where('status','=',1)->where('user_token','FOREVER-MEDSPA')->orderBy('id','DESC')->get();
       
        //  For Auto Search Complete
        $search_category = ProductCategory::where('cat_is_deleted', 0)
        ->where('status','=',1)
        ->where('user_token', 'FOREVER-MEDSPA')
        ->pluck('cat_name')
        ->toArray();
        $search_product=Product::where('product_is_deleted','=',0)->where('status','=',1)->where('user_token','FOREVER-MEDSPA')->pluck('product_name')->toArray();
        $finalarray = array_merge($search_category,$search_product);

        $search = json_encode($finalarray);

    return view('product.services',compact('sliders','data','category','search','popular_service'));
    // return view('product.services',compact('data','category','search','popular_service'));
    // return back()->with('message','No Data Found');
    
   
}
//  All Service And Unit code End 
}
