<?php

namespace App\Http\Controllers;
use App\Models\Gift;
use App\Models\Product;
use App\Models\Giftsend;
use App\Models\EmailTemplate;
use App\Models\GiftcardsNumbers;
use App\Models\GiftCoupon;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Charge;
use Session;
use Mail;
use App\Mail\GeftcardMail;
use App\Mail\GiftReceipt;
use Illuminate\Support\Facades\DB;
use App\Mail\ServicePurchaseConfirmation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class StripeController extends Controller
{

    protected $transactionHistoryController;
    protected $ServiceOrderController;
    

    public function __construct(TransactionHistoryController $transactionHistoryController,ServiceOrderController $ServiceOrderController)
    {
        $this->transactionHistoryController = $transactionHistoryController;
        $this->ServiceOrderController = $ServiceOrderController;
    }


    public function formview(Request $request){
        $giftDetails = $request->session()->get('gift_details');
        if( $giftDetails)
        {
       

            return view('stripe.form',compact('giftDetails'));
        }
        else{
            return redirect('/');
        }
        
    }

       public function makepayment(Request $request,Gift $gift,TransactionHistory $transaction,EmailTemplate $template)
       {
        
        // dd($request->session()->get('gift_details'));

       Stripe::setApiKey(env('STRIPE_SECRET'));

       try {
           $user_id= session('gift_details')['user_id'];
           $amount= session('gift_details')['amount'];
           $template_id = session('gift_details')['template_id'];
           $tomail=session('gift_details')['to'];
          
        //    if template not exist in tamplate list

        if ($template->find($template_id))
        {
            $mail_data = array(session('gift_details'));
        }
        else
        {
            $mail_data = array(session('gift_details'));
            $mail_data['template_id'] = 0;
        }
        
           // Create a charge
          $data= Charge::create([
               'amount' => session('gift_details')['amount'] * 100 , // Amount in cents
               'currency' => 'usd',
               'source' => $request->stripeToken,
               'description' => 'Forever Medspa Giftcards UserId='.$user_id.' Amount $ ='.$amount,
           ]);

        //    Payment successful, you can handle success here

           if($data)
           {
            $giftdata=session('gift_details');
            $result=$gift->create($giftdata);
            $transaction_entry=array(
                'transaction_id'=>$data->source->id,
                'amount'=>($data->amount)/100,
                'user_id'=>$user_id,
                'status'=>$data->status,
                'card_type'=>$data->payment_method_details->card->brand,
                'last_for_digit'=>'xxxx-xxxx-xxxx-'.$data->payment_method_details->card->last4,
            );
            $transaction->create($transaction_entry);
            // $mail_data=array(
            //             'to'=>session('gift_details')['to'],
            //             'from'=>session('gift_details')['from'],
            //             'code'=>session('gift_details')['code'],
            //             'to_name'=>session('gift_details')['to_name'],
            //             'from_name'=>session('gift_details')['from_name'],
            //             'amount'=>session('gift_details')['amount'],
            //             'template_id'=>session('gift_details')['template_id'],
            //             'msg'=>$result->msg,
            //         );
            
            // dd($mail_data);
            Mail::to("$tomail")->send(new GeftcardMail($mail_data));

            $request->session()->flush('gift_details');
            return view('stripe.thanks',compact('data'))->with('success', 'Payment successful.');
           }
       } catch (\Exception $e) {
           // Payment failed, handle the error
           return back()->with('error', $e->getMessage());
       }
    }


    //  Giftcardspayment

    public function giftcardpayment(Request $request,Giftsend $giftsend,GiftcardsNumbers $cardnumber)
       {
           $id=Session::get('gift_id');
           $giftsend = Giftsend::find($id);
           
        // dd($request->session()->get('gift_details'));
       Stripe::setApiKey(env('STRIPE_SECRET'));

       try {

           // Create a charge
          $data= Charge::create([
                'amount' => ($giftsend['amount'] - $giftsend['discount']) * 100, // Amount in cents
               'currency' => 'usd',
               'source' => $request->stripeToken,
               'description' => 'Forever Medspa Giftcards UserId='.$giftsend['id'].' Amount $ ='.$giftsend['amount'],
           ]);

           
        //    Payment successful, you can handle success here
        if($data)
        {
            $transaction_entry = [
                'transaction_id' => $data->source->id,
                'transaction_amount' => $data->amount / 100,
                'payment_status' => $data->status,
                'payment_time' => $data->created,
                'payment_mode' => 'Payment Gateway',
            ];
            // Assuming $giftsend is the instance of the Giftsend model you retrieved earlier
            $mail_data  = $giftsend->update($transaction_entry);

            // For Entry Gift Number Generate Process
            if($data->status=='succeeded')
            {
            $qty=$giftsend->qty;
            for($i=1;$i<=$qty;$i++)
            {

                $randomCode = mt_rand(1000, 9999);
                $date = date('Y');
                $gift_card_code = 'FEMS-' . $date . '-' . $randomCode;
                $cardgenerate = [
                    'user_id' => $giftsend->id,
                    'transaction_id' => $data->source->id,
                    'user_token' => $giftsend->user_token,
                    'amount' => $giftsend->amount / $giftsend->qty,
                    'giftnumber' => $gift_card_code,
                    'status' => 1,
                    'comments' => $giftsend->message,
                ];
                $cardnumber->create($cardgenerate);
            }

            }
            $gift_send_to = $giftsend->gift_send_to;
            $tomail = $giftsend->receipt_email;
            

            if (empty($giftsend->in_future)) {
                Mail::to($gift_send_to)->send(new GeftcardMail($giftsend));
            }
            

            if(!empty($giftsend->recipient_name))
            {

                Mail::to("$tomail")->send(new GiftReceipt($giftsend));
            }

            return view('stripe.thanks',compact('data'))->with('success', 'Payment successful.');
        }
       
       } catch (\Exception $e) {
           // Payment failed, handle the error
        //    return  $e->getMessage();

           return view('stripe.failed')->with('error',  $e->getMessage());
        //    return back()->with('error', $e->getMessage());
       }
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
        $orderId = 'MSWC-SER-'.date('Y')."-".time();
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
                $totalAmount += $cart_data->discounted_amount;
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
            "source" => "Giftcart Website"
        ];

        $this->sendLeadCaptureRequest($api_data);

        DB::commit();  // Commit transaction

    } catch (\Exception $e) {
        DB::rollBack();  // Rollback transaction
        Log::error('Checkout Process Error: ' . $e->getMessage());
        return back()->withErrors(['error' => $e->getMessage()]);
    }

    // Stripe Checkout Session
    try {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $redirecturl = route('strip_checkout_success') . '?session_id={CHECKOUT_SESSION_ID}';

        $response = $stripe->checkout->sessions->create([
            'success_url' => $redirecturl,
            'customer_email' => $request->email,
            'payment_method_types' => ['link', 'card'],
            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => $orderId ?: '',
                        ],
                        'unit_amount' => session()->get('totalValue') ? session()->get('totalValue') * 100 : $final_amount * 100,
                        'currency' => 'USD',
                    ],
                    'quantity' => 1
                ],
            ],
            'mode' => 'payment',
            'allow_promotion_codes' => false,
        ]);

        // Update payment_session_id in TransactionHistory
        TransactionHistory::where('order_id', $orderId)->update(['payment_session_id' => $response->id]);

        return redirect($response['url']);

    } catch (\Exception $e) {
        Log::error('Stripe Checkout Session Error: ' . $e->getMessage());
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


    public function stripcheckoutSuccess(Request $request)
{
    try {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $response = $stripe->checkout->sessions->retrieve($request->session_id);

        $transaction_data = \App\Models\TransactionHistory::where('payment_session_id', $response->id)->first(); 
        $ServiceOrder = \App\Models\ServiceOrder::where('order_id', $transaction_data->order_id)->first(); 
        
        if ($transaction_data) {
            // Prepare the data to be updated
            $data = [
                'payment_status' => $response->payment_status,
                'status' => ($response->status == 'complete') ? 1 : 0,
                'payment_intent' => $response->payment_intent,
                'transaction_status' => $response->status,
                'transaction_amount' => $response->amount_total / 100,
            ];

            // Update the transaction history record
            $transaction_data->update($data);
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

        //  For Purchase Confirmation Mail
        // dd($transaction_data);
        Mail::to($transaction_data->email)->send(new ServicePurchaseConfirmation($transaction_data));

        return redirect()->route('invoice')
                     ->with('transaction_data', $transaction_data)
                     ->with('success', 'Payment successful.');
   
    } catch (\Exception $e) {
        // Log the error message
        \Log::error('Giftcard_Redeem_Statement : ' . $e->getMessage());
        return view('stripe.failed')->with('error', 'Payment processing failed. Please contact support.');
    }
}


public function invoice()
{
    // Retrieve flash data
    $transaction_data = session('transaction_data');
    return view('invoice.service_invoice', compact('transaction_data'));
}



}

