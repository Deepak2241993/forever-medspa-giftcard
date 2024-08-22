<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Auth;
use Session;
use Validator;

class ServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        ServiceOrder::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceOrder $serviceOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceOrder $serviceOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceOrder $serviceOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceOrder $serviceOrder)
    {
        //
    }


      //  for giftcard redeem
      public function ServiceRedeem(Request $request)
      {
          $token = Auth::user()->user_token;
          $data_arr = ['name' => '', 'email' => '', 'giftcardnumber' => '', 'user_token' => $token];
          $data = json_encode($data_arr);
          $result = $this->postAPI('gift-card-search', $data);
      
          if (isset($result['status']) && $result['status'] == 200) {
              $getdata = $result['result'];
      
              // Convert the data array into a Collection
              $collection = collect($getdata);
      
              // Get the current page from the request, default to 1
              $currentPage = LengthAwarePaginator::resolveCurrentPage();
      
              // Define how many items you want per page
              $perPage = 10; // Example: 10 items per page
      
              // Slice the collection to get the items to display in the current page
              $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
      
              // Create our paginator
              $paginatedItems = new LengthAwarePaginator($currentPageItems, $collection->count(), $perPage);
      
              // Set the pagination path
              $paginatedItems->setPath($request->url());
      
              return view('admin.redeem.service_redeem', compact('paginatedItems'));
          } else {
              $error = isset($result['error']) ? $result['error'] : 'Unknown error occurred.';
              return view('admin.redeem.service_redeem')->with('error', $error);
          }
      }
      public function ServiceOrderSearch(Request $request)
{
    $data_arr = $request->except('_token');
    $data = json_encode($data_arr);
    $result = $this->postAPI('order-search', $data);

    if (isset($result['status']) && $result['status'] == 200) {
        // Assuming $result['result'] is the entire response containing pagination data
        $getdata = $result['result'];

        // Extract the data from the result
        $items = $getdata['data'];

        // Get pagination information from the API response
        $currentPage = $getdata['current_page'];
        $perPage = $getdata['per_page'];
        $total = $getdata['total'];

        // Create a LengthAwarePaginator instance
        $paginatedItems = new LengthAwarePaginator($items, $total, $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(), // Set the path for pagination links
            'pageName' => 'page', // This should match the API's pagination parameter (e.g., ?page=1)
        ]);

        return view('admin.redeem.service_redeem', compact('paginatedItems'));
    } else {
        $error = isset($result['error']) ? $result['error'] : 'Unknown error occurred.';
        return view('admin.redeem.service_redeem')->with('error', $error);
    }
}
}
