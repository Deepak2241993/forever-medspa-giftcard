<?php

namespace App\Http\Controllers;

use App\Models\PopularOffer;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\TransactionHistory;
use Stripe\Stripe;
use Stripe\Charge;
use Session;
use Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ServicePurchaseConfirmation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\GiftcardsNumbers;
class PopularOfferController extends Controller
{
    protected $transactionHistoryController;
    protected $ServiceOrderController;
    

    public function __construct(TransactionHistoryController $transactionHistoryController,ServiceOrderController $ServiceOrderController)
    {
        $this->transactionHistoryController = $transactionHistoryController;
        $this->ServiceOrderController = $ServiceOrderController;
    }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PopularOffer  $popularOffer
     * @return \Illuminate\Http\Response
     */
    public function show(PopularOffer $popularOffer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PopularOffer  $popularOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(PopularOffer $popularOffer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PopularOffer  $popularOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PopularOffer $popularOffer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PopularOffer  $popularOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(PopularOffer $popularOffer)
    {
        //
    }

    public function popularDeals(){
        return view('product.offers_details');
    }
    

    public function Cart(Request $request){
         // Validate the request
         $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        // Retrieve cart from session or create a new one
        $cart = session()->get('cart', []);

        // Check if the product is already in the cart
        $productId = $request->product_id;
        if (isset($cart[$productId])) {
            // Update quantity if product exists in cart
            $cart[$productId]['quantity'] += $request->quantity;
        } else {
            // Add new product to cart
            $cart[$productId] = [
                'product_id' => $productId,
                'quantity' => $request->quantity
            ];
        }

        // Save cart back to session
        session()->put('cart', $cart);

        // Redirect back with a success message
        return response()->json(['status'=>'200','success'=> 'Product added to cart successfully!']);
      
    }
   //  For Cart view
    public function Cartview(Request $request){
        return view('product.cart');
    }

    public function AdminCartview(Request $request){
        return view('admin.cart.cart');
    }
    //  For Items Remove From Carts
    public function CartRemove(Request $request){
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            return response()->json(['success' => 'Product removed from cart successfully!']);
        } else {
            return response()->json(['error' => 'Product not found in cart!'], 404);
        }
    }

    public function Checkout(Request $request) {
        $cart = session()->get('cart', []);
    
        if ($request->giftcards != null) {
            // Initialize the giftcards array
            $giftcards = session()->get('giftcards', []);
    
            // Iterate over the giftcards array from the request
            foreach ($request->giftcards as $giftcard) {
                // Add each gift card to the session array
                $giftcards[] = [
                    'number' => $giftcard['number'],
                    'amount' => $giftcard['amount'],
                ];
            }
    
            // Store the updated giftcards array and other values back into the session
            session()->put([
                'giftcards' => $giftcards,
                'total_gift_applyed' => $request->total_gift_applyed,
                'tax_amount' => $request->tax_amount,
                'totalValue' => $request->totalValue,
            ]);
            return response()->json(['status' => 200, 'message' => 'Gift Cards stored in session successfully.']);
        } else {
            return response()->json(['status' => 200, 'message' => 'No Giftcard Apply']);
        }
    }
    






//  For checkout page call
        public function checkoutView(Request $request){
            return view('product.checkout');
        }

        public function AdminPaymentProcess(Request $request){
            return view('admin.cart.payment-process');
        }
    
        public function CheckoutProcess(Request $request)
        {
            
            $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'zip_code' => 'required|digits:6',
                'email' => 'required|email|max:255',
                'phone' => 'required|digits_between:7,10',
                'address' => 'required|string|max:255',
            ]);

            DB::beginTransaction();  // Start transaction

            try {
            
                // Generate New Order For this 
                $orderId = 'MSWC-SER-CT-'.date('Y')."-".time();
                $cartItems = session('cart', []);
                $gift_number = null;
                $gift_amount = null;
                $totalAmount = 0;

        //  If Gift card applyed for redeem
                if (session()->has('total_gift_applyed')) {
                    $cards = session('cart', []);
                    $giftcards = session('giftcards', []);
                    $gift_numbers = [];
                    $gift_amounts = [];
        
                    foreach ($giftcards as $giftcard) {
                        if (isset($giftcard['number'])) {
                            $gift_numbers[] = $giftcard['number'];
                            $gift_amounts[] = $giftcard['amount'];
                        }
                    }

                    $gift_number = implode('|', $gift_numbers);
                    $gift_amount = implode('|', $gift_amounts);
                    $sub_amount = session('totalValue', 0) + session('total_gift_applyed', 0) - session('tax_amount', 0);
                    $final_amount = session('totalValue', 0);
                    $taxamount = session('tax_amount', 0);
                    
                }
                //  If Gift card Not applyed for redeem
                else {
                
                        $cards = session('cart', []);
                
                    foreach ($cards as $item) {
                        $cart_data = Product::find($item['product_id']);
                        $totalAmount += $cart_data->discounted_amount ? $cart_data->discounted_amount : $cart_data->amount;
                    }

                    $taxamount = ($totalAmount * 10) / 100;
                    $sub_amount = $totalAmount;
                    $final_amount = $totalAmount + $taxamount;
                }

                $data = [
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'city' => $request->city,
                    'country' => $request->country,
                    'zip_code' => $request->zip_code,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'order_id' => $orderId,
                    'gift_card_applyed' => $gift_number ? $gift_number:null,
                    'gift_card_amount' => $gift_amount ? $gift_amount :null,
                    'sub_amount' => $sub_amount,
                    'final_amount' => $final_amount,
                    'address' => $request->address,
                    'tax_amount' => $taxamount,
                    'user_token' => 'FOREVER-MEDSPA',
                    'transaction_amount'=>$final_amount,
                    'status'=>1,
                    'payment_status'=>$request->transaction_status=='complete'?'paid':'not-paid',
                    'transaction_status'=>$request->transaction_status,
                    'payment_session_id'=>'Service-Purchse_From-Center',
                    'payment_intent'=>'Store-Purchases-'.date('m-d-Y'),
                    'payment_mode' => 'store-purchase',
                    
                ];

                
                // Store data in TransactionHistory
                // TransactionHistory::create($data);
                $result =  $this->transactionHistoryController->store(new \Illuminate\Http\Request($data));
                
                // Store data in ServiceOrder table
            
                foreach ($cards as $item) {
                    $cart_data = Product::find($item['product_id']);

                    $order_data = [
                        'order_id' => $orderId,
                        'service_id' => $item['product_id'],
                        'status' => 0,
                        'number_of_session' => $cart_data->session_number,
                        'user_token' => 'FOREVER-MEDSPA',
                        'actual_amount' => $cart_data->amount,
                        'discounted_amount' => $cart_data->discounted_amount,
                        'payment_mode' => 'store-purchase',
                    ];

                    // ServiceOrderController::create($order_data);
                    $this->ServiceOrderController->store(new \Illuminate\Http\Request($order_data));
                }

                // API Code for Storing Data in Lead Capture
                $api_data = [
                    "first_name" => $request->fname,
                    "last_name" => $request->lname,
                    "email" => $request->email,
                    "phone" => $request->phone,
                    "message" => "This is Comes From Giftcart Payment Page",
                    "source" => "Giftcart Website",
                  
                ];

                $this->sendLeadCaptureRequest($api_data);

                DB::commit();  // Commit transaction
                $transaction_data = \App\Models\TransactionHistory::where('order_id',$orderId)->first(); 
                $ServiceOrder = \App\Models\ServiceOrder::where('order_id', $transaction_data->order_id)->first(); 

                if ($transaction_data) {
                    // Prepare the data to be updated
     
                    $ServiceOrder->update(['status' => 1]);
        
                    if ($transaction_data->gift_card_applyed != null) {
                        $giftcardnumbers = explode('|', $transaction_data->gift_card_applyed);
                        $giftcardamounts = explode('|', $transaction_data->gift_card_amount);
        
                        foreach ($giftcardnumbers as $key => $value) {
                            $giftcard_result = \App\Models\GiftcardsNumbers::where('giftnumber', $value)->first();
        
                            if ($giftcard_result) {
                                $data_arr = [
                                    'gift_card_number' => $value,
                                    'amount' => $giftcardamounts[$key],
                                    'comments' => "You have redeemed your giftcard " . $giftcardnumbers[$key] . " on the purchase of the service Order Number: " . $transaction_data->order_id,
                                    'user_id' => $giftcard_result->user_id,
                                    'user_token' => 'FOREVER-MEDSPA',
                                ];
        
                                $data = json_encode($data_arr);
        
                                $result = $this->postAPI('gift-card-redeem', $data);
        
                                if ($result['status'] == 200) {
                                    $data_arr['gift_card_number'] = $value;
                                    $data_arr['user_token'] = 'FOREVER-MEDSPA';
        
                                    $data = json_encode($data_arr);
                                    $statement = $this->postAPI('gift-card-statment', $data);
                                    $giftcard_result = \App\Models\GiftcardsNumbers::where('giftnumber', $value)->first();
                                    $statement['giftCardHolderDetails'] = $result['giftCardHolderDetails'];
                                    \Mail::to($result['giftCardHolderDetails']['gift_send_to'])->send(new \App\Mail\GiftCardStatement($statement));
                                }
                            }
                        }
                    }
                    session::pull('giftcards');
                    session::pull('total_gift_applyed');
                    session::pull('tax_amount');
                    session::pull('totalValue');
                    session::pull('cart');
                }

        Mail::to($transaction_data->email)->send(new ServicePurchaseConfirmation($transaction_data));
        return redirect()->route('service-invoice', ['transaction_data' => $transaction_data]);
            } catch (\Exception $e) {
                DB::rollBack();  // Rollback transaction
                Log::error('Checkout Process Error: ' . $e->getMessage());
                return back()->withErrors(['error' => $e->getMessage()]);
            }

           
        }

    private function sendLeadCaptureRequest(array $api_data)
    {
        try {
            $api_data = json_encode($api_data);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post(env('LEAD_API_URL') . "capture", $api_data);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Lead Capture API Error: ' . $e->getMessage());
        }
    }


    public function invoice($transaction_data) {
        $transaction_data = TransactionHistory::where('id',$transaction_data)->first();
        return view('admin.cart.invoice', compact('transaction_data'));
    }
    

}
