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
use Mail;
use App\Mail\ServiceRedeemReceipt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


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
              'order_id' => 'required|string|max:255',
              'number_of_session_use' => 'required|integer|min:1',
              'comments' => 'nullable|string|max:255',
          ]);
      
          // Create a new record using the validated data
        //   try {
          $data = $request->all();
          $data['user_token']='FOREVER-MEDSPA';
          $data['transaction_id']='SER-RED'.time();
         $result= $service_redeem->create($data);
            // } catch (\Exception $e) {
            //     Log::error('Service Redeem Data Entry: ' . $e->getMessage());
            //     return back()->withErrors(['error' => $e->getMessage()]);
            // }
         if($result)
         {
            // try {
            $transactionresult = TransactionHistory::where('order_id',$result->order_id)->first();
            Mail::to($transactionresult->email)->send(new ServiceRedeemReceipt($transactionresult));
            // } catch (\Exception $e) {
            //     Log::error('Service Redeem Statment Email: ' . $e->getMessage());
            //     return back()->withErrors(['error' => $e->getMessage()]);
            // }
         }
      
          // Return a JSON response indicating success
          return response()->json(['success' => true, 'message' => 'Service redeemed successfully.']);
      }
      
      public function SearchServiceOrder(Request $request, TransactionHistory $transaction)
        {
            // Start with a base query
            $query = $transaction->query();

            // Apply different logic based on user type
            if (Auth::user()->user_type == 1) {
                // Admin user type logic: filter based on form inputs
                if ($request->filled('order_id')) {
                    $query->where('order_id', 'LIKE', '%' . $request->order_id . '%');
                }

                if ($request->filled('email')) {
                    $query->where('email', 'LIKE', '%' . $request->email . '%');
                }

                if ($request->filled('phone')) {
                    $query->where('phone', 'LIKE', '%' . $request->phone . '%');
                }

            } else {
                // Non-admin user logic: filter based on user ID
                $id = Auth::user()->id;
                $query->where('user_id', $id);
            }

            // Order and paginate results
            $data = $query->orderBy('id', 'DESC')->paginate(10);

            return view('admin.redeem.service_redeem', compact('data'));
        }

        public function getServiceStatement(Request $request)
        {
            $orderId = $request->order_id;
            
            $servicePurchases = ServiceOrder::select('service_orders.*', 'products.product_name')
                ->join('products', 'service_orders.service_id', '=', 'products.id')
                ->where('service_orders.order_id', $orderId)
                ->get();
        
            $serviceRedeem = Service_redeem::select('service_redeems.*', 'products.product_name')
                ->join('products', 'service_redeems.service_id', '=', 'products.id')
                ->where('service_redeems.order_id', $orderId)
                ->get();
        
            $totalAmount = $servicePurchases->sum('number_of_session') - $serviceRedeem->sum('number_of_session_use');
        
            return response()->json([
                'success' => true,
                'servicePurchases' => $servicePurchases,
                'serviceRedeem' => $serviceRedeem,
                'totalAmount' => $totalAmount
            ]);
        }
        

}
