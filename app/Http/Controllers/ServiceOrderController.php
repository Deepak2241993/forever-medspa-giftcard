<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Models\TransactionHistory;
use App\Models\Service_redeem;

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

public function ServiceRedeemView(Request $request,TransactionHistory $transaction)
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

      }

      public function ServiceRedeem(Request $request, Service_redeem $service_redeem)
      {
          // Validate the request data
          $validatedData = $request->validate([
              'service_id' => 'required|integer',
              'session_number' => 'required|integer|min:1',
              'message' => 'nullable|string|max:255',
          ]);
      
          // Create a new record using the validated data
          $service_redeem->create($validatedData);
      
          // Return a JSON response indicating success
          return response()->json(['success' => true, 'message' => 'Service redeemed successfully.']);
      }
      
}
