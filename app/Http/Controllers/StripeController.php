<?php

namespace App\Http\Controllers;
use App\Models\Gift;
use App\Models\Giftsend;
use App\Models\EmailTemplate;
use App\Models\GiftcardsNumbers;
use App\Models\GiftCoupon;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Validator;
use Stripe\Stripe;
use Stripe\Charge;
use Session;
use Mail;
use App\Mail\GeftcardMail;
use App\Mail\GiftReceipt;

class StripeController extends Controller
{
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
           return back()->with('error', $e->getMessage());
       }
    }








}

