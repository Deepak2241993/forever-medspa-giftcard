<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Models\TransactionHistory;
use App\Models\ServiceRedeem;
use App\Models\Product;
use App\Models\ServiceUnit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Mail;
use DB;
use App\Mail\DealsCancle;
use App\Mail\ServiceRedeemReceipt;
use App\Mail\RefundReceiptMail;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Refund;

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

      public function ServiceRedeem(Request $request, ServiceRedeem $service_redeem)
      {
          // Validate the request data
          $validatedData = $request->validate([
              'order_id' => 'required|string|max:255',
              'number_of_session_use' => 'required|integer|min:1',
              'comments' => 'nullable|string|max:255',
          ]);
      
          // Create a new record using the validated data
        //   try {
            $data = $request->all();
            $data['user_token'] = 'FOREVER-MEDSPA';
            $data['transaction_id'] = 'SER-RED' . time();
            
            // Create the record and get the inserted model instance
            $result = $service_redeem->create($data);
            
            // Update the transaction ID with the concatenated latest inserted ID
            if ($result) {
                $result->transaction_id = 'SER-RED' . $result->id;
                $result->save();
                $transactionresult = TransactionHistory::where('order_id',$result->order_id)->first();
                Mail::to($transactionresult->email)->send(new ServiceRedeemReceipt($transactionresult));
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

            // Fetch service purchases with product and unit details
            $servicePurchases = ServiceOrder::select(
                'service_orders.*', 
                'products.product_name', 
                'service_units.product_name as unit_name'
            )
            ->leftJoin('products', 'service_orders.service_id', '=', 'products.id')
            ->leftJoin('service_units', 'service_orders.service_id', '=', 'service_units.id')
            ->where('service_orders.order_id', $orderId)
            ->get();

            // Fetch service redeems with product and unit details
            $serviceRedeem = ServiceRedeem::select(
                'service_redeems.*',
                'products.product_name',
                'service_units.product_name as unit_name'
            )
            ->leftJoin('products', 'service_redeems.product_id', '=', 'products.id')
            ->leftJoin('service_units', 'service_redeems.product_id', '=', 'service_units.id')
            ->where('service_redeems.order_id', $orderId)
            ->get();

            // Calculate total remaining sessions
            $totalAmount = $servicePurchases->sum('number_of_session') - $serviceRedeem->sum('number_of_session_use');

            return response()->json([
                'success' => true,
                'servicePurchases' => $servicePurchases,
                'serviceRedeem' => $serviceRedeem,
                'totalAmount' => $totalAmount,
            ]);
        }


        //  For Redeem Calculation 
        public function redeemcalculation(Request $request)
        {
            $orderId = $request->order_id;

            // Fetch service purchases with remaining sessions
            $servicePurchases = ServiceOrder::select(
                'service_orders.*',
                'products.product_name',
                'service_units.product_name as unit_name',
                DB::raw('(service_orders.number_of_session - COALESCE(SUM(service_redeems.number_of_session_use), 0)) as remaining_sessions')
            )
            ->leftJoin('products', 'service_orders.service_id', '=', 'products.id')
            ->leftJoin('service_units', 'service_orders.service_id', '=', 'service_units.id')
            ->leftJoin('service_redeems', 'service_orders.id', '=', 'service_redeems.service_order_id')
            ->where('service_orders.order_id', $orderId)
            ->groupBy(
                'service_orders.id',
                'products.product_name',
                'service_units.product_name',
                'service_orders.number_of_session',
                'service_orders.order_id',
                'service_orders.service_id',
                'service_orders.created_at',
                'service_orders.updated_at',
                'service_orders.service_type',
                'service_orders.qty',
                'service_orders.status',
                'service_orders.is_deleted',
                'service_orders.updated_by',
                'service_orders.actual_amount',
                'service_orders.discounted_amount',
                'service_orders.payment_mode',
                'service_orders.user_token'
            )
            ->get();

            // Calculate total remaining sessions
            $totalRemainingSessions = $servicePurchases->sum('remaining_sessions');

            return response()->json([
                'success' => true,
                'servicePurchases' => $servicePurchases,
                'totalRemainingSessions' => $totalRemainingSessions,
            ]);
        }


     
        
        public function DoCancel(Request $request, ServiceRedeem $service_redeem)
{
    // Validate the request data
    $request->validate([
        'product_id' => 'required|integer',
        'order_id' => 'required|string|max:255',
        'number_of_session_use' => 'required|integer|min:1',
        'comments' => 'nullable|string|max:255',
    ]);

    try {
        $data = $request->all();
        $data['user_token'] = 'FOREVER-MEDSPA';
        
        $result = $service_redeem->create($data);

        if ($result) {
            $result->transaction_id = 'SER-CAN-' . $result->id;
            $result->save();

            $transactionresult = TransactionHistory::where('order_id', $result->order_id)->first();

            try {
                // Send cancellation email
                Mail::to($transactionresult->email)->send(new DealsCancle($transactionresult));
            } catch (\Exception $e) {
                // Log if email sending fails
                Log::error('Email sending failed: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Failed to send cancellation email.']);
            }

            // For online payment refund
            if ($transactionresult->payment_mode == 'online') {
                try {
                    // Payment Refund Process
                    Stripe::setApiKey(env('STRIPE_SECRET'));
                    $refund = Refund::create([
                        'payment_intent' => $transactionresult->payment_intent,  // Use actual Payment Intent ID
                        'amount' => $request->refund_amount * 100,  // Amount is in cents
                        'reason' => 'requested_by_customer',  // Reason for refund
                    ]);

                    $balanceTransaction = \Stripe\BalanceTransaction::retrieve($refund->balance_transaction);

                    // After a successful refund, send a receipt
                    $this->sendRefundReceipt($transactionresult->email, $refund);
                    // for update status 
                    $result->update(['status' => 0]);

                } catch (\Exception $e) {
                    // Log if refund process fails
                    Log::error('Stripe Refund failed: ' . $e->getMessage());
                    return response()->json(['success' => false, 'message' => 'Failed to process refund.']);
                }
            }
            else{
                $result->update(['status' => 0]);
            }

            // Success Response
            return response()->json(['success' => true, 'message' => 'Service redeemed and refund processed successfully.']);
        }

        return response()->json(['success' => true, 'message' => 'Service redeemed successfully.', 'return_process' => 'store-purchase']);
    } catch (\Exception $e) {
        // Log any general failure
        Log::error('DoCancel Process failed: ' . $e->getMessage());
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}

/**
 * Function to send refund receipt to the customer
 */
private function sendRefundReceipt($email, $refund)
{
    try {
        // Send the refund receipt email
        Mail::to($email)->send(new RefundReceiptMail($refund));

        // Log the successful sending of the refund receipt
        Log::info('Refund receipt sent successfully to ' . $email);
    } catch (\Exception $e) {
        // Log if sending receipt fails
        Log::error('Failed to send refund receipt to ' . $email . ': ' . $e->getMessage());
    }
}


public function ServiceCancel(Request $request)
{
    $query = ServiceRedeem::where('service_redeems.status', 0)
        ->select('service_redeems.*', 'products.product_name as service_name', 'transaction_histories.payment_intent')
        ->join('products', 'products.id', '=', 'service_redeems.service_id')
        ->join('transaction_histories', 'transaction_histories.order_id', '=', 'service_redeems.order_id')
        ->orderBy('service_redeems.id', 'DESC');

    // Check if the transaction_id parameter is present in the request
    if ($request->filled('transaction_id')) {
        $transaction_id = $request->input('transaction_id');
        $query->where(function($q) use ($transaction_id) {
            $q->where('service_redeems.transaction_id', 'like', "%$transaction_id%")
            ->orWhere('service_redeems.order_id', 'like', "%$transaction_id%")
              ->orWhere('transaction_histories.payment_intent', 'like', "%$transaction_id%");
        });
    }

    $cancel_deals = $query->paginate(10);

    return view('admin.redeem.all_redeemed', compact('cancel_deals'));
}





}
