<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Models\TransactionHistory;

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

public function ServiceRedeem(Request $request,TransactionHistory $transaction)
      {


        if(Auth::user()->user_type==1)
        {
        $data=$transaction->orderBy('id','DESC')->paginate(10);
        }
        else{
            $id=Auth::user()->id;
            $data=$transaction->where('user_id',$id)->orderBy('id','DESC')->get();
        }
        return view('admin.redeem.service_redeem',compact('data'));


        //   $token = Auth::user()->user_token;
        //   $data_arr = ['name' => '', 'email' => '', 'giftcardnumber' => '', 'user_token' => $token];
        //   $data = json_encode($data_arr);
        //   $result = $this->postAPI('order-search', $data);
      
        //   if (isset($result['status']) && $result['status'] == 200) {
        //       $results = $result['result']; // Service data
        //       // Pagination logic
        //       $currentPage = $request->input('page', 1); // Current page from query string
        //       $perPage = 10; // Number of items per page
      
        //       // Create a new LengthAwarePaginator instance with the API response data
        //       $paginatedTransactions = new LengthAwarePaginator(
        //           collect($results)->forPage($currentPage, $perPage),
        //           count($results),
        //           $perPage,
        //           $currentPage,
        //           [
        //               'path' => $request->url(),
        //               'query' => $request->query(),
        //           ]
        //       );
      
        //       return view('admin.redeem.service_redeem', [
        //           'results' => $results
        //       ]);
        //   } else {
        //       $error = isset($result['error']) ? $result['error'] : 'Unknown error occurred.';
        //       return view('admin.redeem.service_redeem')->with('error', $error);
        //   }
      }
// public function ServiceOrderSearch(Request $request)
// {
//     // Collect all request data except the '_token'
//     $data_arr = $request->except('_token');
//     $data = json_encode($data_arr);
    
//     // Make the API call
//     $result = $this->postAPI('order-search', $data);

//     if (isset($result['status']) && $result['status'] == 200) {
//         // Get the result data
//         $getdata = $result['result'];

//         // Extract the data array and pagination details
//         $items = $getdata['data'] ?? []; // Safely handle if 'data' key is not present
//         $currentPage = $getdata['current_page'] ?? 1; // Default to 1 if not present
//         $perPage = $getdata['per_page'] ?? 10; // Default to 10 if not present
//         $total = $getdata['total'] ?? count($items); // Default to count of items if not present

//         // Create a LengthAwarePaginator instance
//         $paginatedItems = new LengthAwarePaginator($items, $total, $perPage, $currentPage, [
//             'path' => $request->url(), // Get the full URL path of the current request
//             'query' => $request->query(), // Retain the existing query string parameters
//             'pageName' => 'page', // Match the API's pagination parameter
//         ]);

//         return view('admin.redeem.service_redeem', compact('paginatedItems'));
//     } else {
//         $error = $result['error'] ?? 'Unknown error occurred.';
//         return view('admin.redeem.service_redeem')->with('error', $error);
//     }
// }
}
