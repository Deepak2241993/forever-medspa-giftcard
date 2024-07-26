<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Str;
class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


public function index(Request $request)
{
    $token= Auth::user()->user_token;
    $data_arr = ['user_token'=>$token];
    $data = json_encode($data_arr);
    $data = $this->postAPI('category-list', $data);
    return view('admin.product.category_index',compact('data'));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.product.category_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function store(Request $request, ProductCategory $category)
    {
    // Ensure the user is authenticated and retrieve the user's token
    $token = Auth::user()->user_token;

    // Retrieve all request data except '_token'
    $data = $request->except('_token');

    // Add the user's token to the data
    $data['user_token'] = $token;

    if ($request->hasFile('cat_image')) {
        $folder = str_replace(" ", "_", $token);
        $image = $request->file('cat_image');
        $destinationPath = '/uploads/' . $folder."/";
        $filename = $image->getClientOriginalName();
        $image->move(public_path($destinationPath), $filename);
        $data['cat_image'] = url('/').$destinationPath.$filename;
    }
    // Send data to API endpoint using cURL
    $curl = curl_init();
  
    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => env('API_URL') . 'category-created', // API URL
        CURLOPT_RETURNTRANSFER => true, // Return the response as a string
        CURLOPT_ENCODING => '', // Enable compression
        CURLOPT_MAXREDIRS => 10, // Follow up to 10 redirects
        CURLOPT_TIMEOUT => 0, // No timeout
        CURLOPT_FOLLOWLOCATION => true, // Follow redirects
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // HTTP version
        CURLOPT_CUSTOMREQUEST => 'POST', // Request method
        CURLOPT_POSTFIELDS => $data, // POST data
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic Og==' // Example authorization header
        ),
    ));
    
    // Execute cURL request
    $result = curl_exec($curl);
    // Check for errors
    if(curl_errno($curl)) {
        // Handle cURL error
        $error_message = curl_error($curl);
        // You may want to log or handle the error appropriately
        return "cURL Error: " . $error_message;
    }

    // Close cURL session
    curl_close($curl);

    // Decode the JSON response
    $result = json_decode($result, true);

    // Check the result of the API call
    if ($result && isset($result['status']) && $result['status'] == 200) {
        // Redirect with success message if the API call was successful
        return redirect(route('category.index'))->with('success', $result['msg']);
    } else {
        // Redirect back with error message if the API call failed
        return redirect()->back()->with('error', $result['msg']);
    }
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory,$id)
    {
        $token= Auth::user()->user_token;
        $data_arr = ['user_token'=>$token];
        $data = json_encode($data_arr);
        $data = $this->getAPI('category/'.$id.'?user_token='.$token);
        $data=$data['result'];
        return view('admin.product.category_create',compact('data')); }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */


public function update(Request $request,$id)
{
    $token= Auth::user()->user_token;
    $data = $request->except('_token','_method');
    $data['user_token'] = $token;

    if ($request->hasFile('cat_image')) {
        $folder = str_replace(" ", "_", $token);
        $image = $request->file('cat_image');
        $destinationPath = '/uploads/' . $folder."/";
        $filename = $image->getClientOriginalName();
        $image->move(public_path($destinationPath), $filename);
        $data['cat_image'] = url('/').$destinationPath.$filename;
    }
    
    $data = json_encode($data);
    $data = $this->postAPI('category-update/'.$id,$data);

    return redirect(route('category.index'))->with('success', $data['msg']);
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */

 
     public function destroy(Request $request,$id)
     {
           
            // Get user token
            $token = Auth::user()->user_token;
            
            // Prepare data for API call
            $data_arr = ['user_token'=>$token, 'id'=>$id];
            $data = json_encode($data_arr);
            
            // Make API call to delete category
            $response = $this->postAPI('categoryDelete/' . $id, $data);
         // Check if API call was successful
         if ($response && isset($response['status']) && $response['status']==200) {
             return redirect(route('category.index'))->with('success', $response['msg']);
         }
          else {
             // If deletion fails, handle the error appropriately
             return redirect()->back()->with('error', $response['msg']);
         }
     }

     public function categorytpage(){
        $date=date('Y-m-d');
        $data=ProductCategory::where('cat_is_deleted',0)
        ->where('status',1)
        ->where('user_token','FOREVER-MEDSPA')
        ->where('deal_start_date','<=',$date)
        ->where('deal_end_date','>=',$date)
        ->orderBy('id','DESC')
        ->paginate(10);
        $popular_service=Product::where('popular_service',1)->where('product_is_deleted',0)->where('user_token','FOREVER-MEDSPA')->get();
       
        //  For Auto Search Complete
        $search_category = ProductCategory::where('cat_is_deleted', 0)
        ->where('user_token', 'FOREVER-MEDSPA')
        ->pluck('cat_name')
        ->toArray();
        $search_product=Product::where('product_is_deleted',0)->where('user_token','FOREVER-MEDSPA')->pluck('product_name')->toArray();
        $finalarray = array_merge($search_category,$search_product);

        $search = json_encode($finalarray);
        return view('product.category',compact('data','search','popular_service'));
     }


     function slugCreate(Request $request){
        $slug= Str::slug($request->product_name);
        return response()->json(['success' => 'Slug Created!','slug'=>$slug]);
     }
     

  


}




