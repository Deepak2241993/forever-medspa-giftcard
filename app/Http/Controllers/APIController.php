<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GiftCoupon;
use App\Models\MedsapGift;
use App\Models\GiftCategory;
use App\Models\Giftsend;
use App\Models\GiftcardsNumbers;
use App\Models\User;
use App\Models\TransactionHistory;
use App\Models\GiftcardRedeem;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Mail\GeftcardMail;
use App\Mail\GiftReceipt;
use Auth;
use Mail;
use Session;
use Validator;
use DB;

class APIController extends Controller
{
/**
 * @OA\Post(
 *      tags={"Coupon Code"},
 *     path="/coupon-validate",
 *     summary="Validate coupon",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="coupon_code", type="string", example="SAKRAT30"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *                 @OA\Property(property="amount", type="integer", example="50"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
public function giftvalidate(Request $request, GiftCoupon $giftCoupon,MedsapGift $gift){
    $result = $giftCoupon->where('coupon_code', $request->coupon_code)->where('status', 1)->where('user_token',$request->user_token)->get();


    if ($result->isEmpty()) {
        return response()->json(['status'=>'404','error' =>$request->coupon_code.' is not a valid code for the purchase']);
    } else {
        $condition=$result[0]->apply_condition;

        // for GiftAll Result
        $gift_amount=$request->amount;
        
        $finalresult = str_replace('Amount', $gift_amount, $condition);
        
        
        
        if (eval("return ($finalresult);"))
         {
            return response()->json(['data' => $result,'status'=>'200','success'=>'Successfully applied promo code '.$request->coupon_code], 200);
        }
        else{
            return response()->json(['status'=>'404','error' =>$request->coupon_code.' is not a valid code for the purchase']);
        }

    }
}

/**
 * @OA\Post(
 *      tags={"Gift-Cards"},
 *     path="/gift-for-other",
 *     summary="Gift Send For  Someone else",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="amount", type="integer", example="20"),
 *                 @OA\Property(property="gift_send_for", type="string", example="someone"),
 *                 @OA\Property(property="qty", type="integer", example="20"),
 *                 @OA\Property(property="your_name", type="string", example="Deepak Prasad"),
 *                 @OA\Property(property="recipient_name", type="string", example="Vishal"),
 *                 @OA\Property(property="recipient_email", type="string", example="Vishal"),
 *                 @OA\Property(property="message", type="string", example="This is Testing"),
 *                 @OA\Property(property="gift_card_send_type", type="string", example="Email"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *                 @OA\Property(property="in_future", type="date", example="12-05-2025"),
 *                 @OA\Property(property="coupon_code", type="string", example="CCODE12"),
 *                 @OA\Property(property="event_id", type="integer", example="5"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
public function gift_send_store_other (Request $request,Giftsend $giftsend,User $user,GiftCoupon $coupon)
{
    $data=$request->all();
   $result= $giftsend->create($data);

   if ($result) {
       $lastId = $result->id;
       $result=$giftsend->find($lastId);
        $result=  json_encode($result);
        return response()->json(['result' => $result, 'status' => 200, 'success' => 'Gift Send Details Inserted Successfully'], 200);
    } else {
        return response()->json(['error' => 'Gift Send Details Not Inserted', 'status' => 404]);
    }

}


/**
 * @OA\Post(
 *      tags={"Gift-Cards"},
 *     path="/gift-for-self",
 *     summary="Gift Send For Self",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="amount", type="integer", example="20"),
 *                 @OA\Property(property="gift_send_for", type="string", example="Self"),
 *                 @OA\Property(property="qty", type="integer", example="20"),
 *                 @OA\Property(property="your_name", type="string", example="Deepak Prasad"),
 *                 @OA\Property(property="gift_send_to", type="email", example="deepak@thetemz.com"),
 *                 @OA\Property(property="gift_card_send_type", type="string", example="Email"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *                 @OA\Property(property="coupon_code", type="string", example="CCODE12"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
public function gift_send_store_self (Request $request,Giftsend $giftsend,User $user,GiftCoupon $coupon)
{
    $data=$request->all();
    $data['receipt_email']=$request->gift_send_to;
    $result=$giftsend->create($data);
    if ($result) {
        $lastId = $result->id;
        $result=$giftsend->find($lastId);
         $result=  json_encode($result);
         return response()->json(['result' => $result, 'status' => 200, 'success' => 'Gift Send Details Inserted Successfully'], 200);
     } else {
         return response()->json(['error' => 'Gift Send Details Not Inserted', 'status' => 404]);
     }

}
/**
 * @OA\Post(
 *      tags={"Gift-Cards"},
 *     path="/gift-list",
 *     summary="For Sended Gift List ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
public function list(Request $request,Giftsend $giftsend,GiftcardsNumbers $numbers)
{
    $token=$request->user_token;
    $result=$giftsend->where('user_token',$token)->orderBy('id','DESC')->get();

    if ($result) {
        return response()->json(['result' => $result, 'status' => 200, 'success' => 'All Gift List'], 200);
    } else {
        return response()->json(['error' => 'No Data Found', 'status' => 404]);
    }
}

//  for Know Balnce bo Gift cards

/**
 * @OA\Post(
 *      tags={"Transaction"},
 *     path="/giftcard-balance-check",
 *     summary="For Know Your Giftcard Balance ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="gift_card_number", type="string", example="FEMS-2024-6387"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
public function balancecheck(Request $request, Giftsend $giftsend, GiftcardsNumbers $numbers) {
    $card_no = $request->gift_card_number;
    $user_token = $request->user_token;

    // Calculate the balance of the gift card
    $balance = GiftcardsNumbers::where('user_token', $user_token)
    ->where('giftnumber', $card_no)
    ->sum('amount');

    // Now $balance contains the balance of the gift card
    // return response()->json(['balance' => '$'.$balance]);
    if ($balance>0) {
        $message = "Your Giftcard Available Balance is $$balance";
         return response()->json(['result' => $message, 'status' => 200], 200);
     }
     if ($balance==0) {
        $message = "Your Giftcard Available Balance is $$balance";
         return response()->json(['result' => $message, 'status' => 200], 200);
     }

      else {
         return response()->json(['error' => 'No Data Found', 'status' => 404]);
     }

}

/**
 * @OA\Post(
 *      tags={"Authentication"},
 *     path="/auth-login",
 *     summary="For Authentication ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="email", type="email", example="deepak@thetemz.com"),
 *                @OA\Property(property="password", type="string", example="12345678"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
public function authlogin(Request $request,User $user)
{
            $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|alphaNum|min:8'
           ]);
      
           $user_data = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password')
           );
      
           if(Auth::attempt($user_data))
           {
                $result = Auth::user();
                $response = array('success' => true, 'error' => false, 'message' => 'Login successfully..','result'=>$result);
                return $response;
            }
        else{
            $response = array('success' => false, 'error' => true, 'message' => 'Please Check User Details');
            return $response;
             }
}


/**
 * @OA\Post(
 *      tags={"Authentication"},
 *     path="/auth-registration",
 *     summary="For Authentication ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="name", type="string", example="Deepak Prasad"),
 *              @OA\Property(property="email", type="email", example="deepak@thetemz.com"),
 *              @OA\Property(property="password", type="string", example="12345678"), 
 *              @OA\Property(property="user_type", type="string", example="1"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
 
public function authregistration(Request $request, User $user) {
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'user_type' => 'required',
    ]);

    $token = bin2hex(random_bytes(16));
    
    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'remember_token' => $token,
        'password' => bcrypt($request->input('password')),
    ]);

    $lastInsertedId = $user->id; // Get the last inserted ID
    

    $result = auth()->login($user); // Define $result variable here
    $result=User::find($lastInsertedId);
    if ($lastInsertedId) {
        return response()->json(['result' => $result, 'status' => 200, 'success' => 'User created successfully'], 200);
    } else {
        return response()->json(['error' => 'User creation failed', 'status' => 404]);
    }
}


/**
 * @OA\Post(
 *      tags={"Authentication"},
 *     path="/auth-forgetpassword",
 *     summary="For Forget Password ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="email", type="email", example="deepak@thetemz.com"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
public function forgetpassword(Request $request, User $user) {
    $this->validate($request, [
        'email' => 'required|email',
    ]);

    $user = User::where('email', $request->email)->first(); // Retrieve the user by email

    if ($user) {
        $token = bin2hex(random_bytes(16)); // Generate a random token
        
        // Update user's token in the database
        $user->update(['token' => $token]);
        
        // Here you might send an email to the user with the token for password reset
        
        return response()->json(['message' => 'Token generated and sent successfully', 'status' => 200], 200);
    } else {
        return response()->json(['error' => 'User not found', 'status' => 404]);
    }
}


// for giftcards list

public function cardgenerated(Request $request, User $user,GiftcardsNumbers $number,Giftsend $giftsend){
    $token=$request->user_token;
    $data=$giftsend->where('user_token',$token)->orderBy('id','DESC')->get();

    if ($data) {
        return response()->json(['result' => $data, 'status' => 200, 'success' => 'All Gift List'], 200);
    } else {
        return response()->json(['error' => 'No Data Found', 'status' => 404]);
    }
}

/**
 * @OA\Post(
 *      tags={"Transaction"},
 *     path="/cardview",
 *     summary="View Card Number Transaction Wise ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="tid", type="string", example="card_1Oko6lHXhy3bfGAtquteqkgE"),
 *              @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
public function cardview(Request $request, User $user,GiftcardsNumbers $number){
    $tid=$request->tid;
    $user_token=$request->user_token;
    $data=$number->where('transaction_id',$tid)->where('user_token',$user_token)->get();

    if ($data) {
        return response()->json(['result' => $data, 'status' => 200, 'success' => 'Gift Cards Found'], 200);
    } else {
        return response()->json(['error' => 'Cards Number Not Found', 'status' => 404]);
    }


}
// For Search Gift Cards
/**
 * @OA\Post(
 *      tags={"Gift-Cards"},
 *     path="/gift-card-search",
 *     summary="For Gift Card Search ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="name", type="string", example="Deepak Kumar"),
 *                 @OA\Property(property="email", type="string", example="deepak@thetemz.com"),
 *                 @OA\Property(property="giftcardnumber", type="string", example="FEMS-2024-8147"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */

 public function GiftCardSearch(Request $request, Giftsend $giftsend, GiftcardsNumbers $numbers)
{
    $token = $request->user_token;
    $name = $request->name;
    $email = $request->email;
    $giftcardnumber = $request->giftcardnumber;

    $query = DB::table('giftsends')
    ->join('giftcards_numbers', 'giftcards_numbers.user_id', '=', 'giftsends.id')
    ->select(
        'giftsends.recipient_name',
        'giftsends.your_name',
        'giftsends.gift_send_to',
        'giftsends.user_token',
        'giftcards_numbers.giftnumber',
        'giftcards_numbers.user_id',
        'giftcards_numbers.status',
        DB::raw('SUM(giftcards_numbers.amount) as total_amount')
    );
    if (!empty($name)) {
        $query->where('giftsends.recipient_name', 'like', '%' . $name . '%')->orWhere('giftsends.your_name','like', '%' . $name . '%');
    }

    if (!empty($email)) {
        $query->where('giftsends.gift_send_to', 'like', '%' . $email . '%');
    }
    if (!empty($giftcardnumber)) {
        $query->where('giftcards_numbers.giftnumber', $giftcardnumber);
    }

    $query->where('giftcards_numbers.user_token', $token)
    ->groupBy(
        'giftsends.recipient_name',
        'giftsends.your_name',
        'giftsends.gift_send_to',
        'giftsends.user_token',
        'giftcards_numbers.giftnumber',
        'giftcards_numbers.user_id',
        'giftcards_numbers.status',
    );
    $result = $query->get();

    
    if ($result) {
        return response()->json(['result' => $result, 'status' => 200, 'success' => 'Gift Cards Found'], 200);
    } else {
        return response()->json(['error' => 'Cards Number Not Found', 'status' => 404]);
    }
}
// For Validate Gift Cards
/**
 * @OA\Post(
 *      tags={"Gift-Cards"},
 *     path="/gift-card-validate",
 *     summary="For Gift Card Search ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="giftcardnumber", type="string", example="FEMS-2024-8147"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */

 public function GiftCardvalidate(Request $request, Giftsend $giftsend, GiftcardsNumbers $numbers)
{
    $token = $request->user_token;
    $giftcardnumber = $request->giftcardnumber;

    $query = DB::table('giftsends')
    ->join('giftcards_numbers', 'giftcards_numbers.user_id', '=', 'giftsends.id')
    ->select(
        'giftsends.user_token',
        'giftcards_numbers.giftnumber',

        DB::raw('SUM(giftcards_numbers.amount) as total_amount')
    );

    if (!empty($giftcardnumber)) {
        $query->where('giftcards_numbers.giftnumber', $giftcardnumber);
    }

    $query->where('giftcards_numbers.user_token', $token)
    ->groupBy(
       
        'giftsends.user_token',
        'giftcards_numbers.giftnumber',
    );
    $result = $query->first();

    
    if ($result) {
        return response()->json(['result' => $result, 'status' => 200, 'success' => 'Gift Cards Found'], 200);
    } else {
        return response()->json(['error' => 'Cards Number Not Found', 'status' => 404]);
    }
}

//  for Giftcards Redeem
/**
 * @OA\Post(
 *      tags={"Gift-Cards"},
 *     path="/gift-card-redeem",
 *     summary="For Gift Redeem ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="gift_card_number", type="string", example="FEMS-2024-8147"),
 *                 @OA\Property(property="comments", type="string", example="I Want To Redeem My Giftcard"),
 *                 @OA\Property(property="amount", type="flout", example="20"),
 *                 @OA\Property(property="user_id", type="integer", example="6"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */

 public function GiftCardredeem(Request $request, Giftsend $giftsend, GiftcardsNumbers $numbers){
    $data=[
        'giftnumber'=>$request->gift_card_number,
        'user_token'=>$request->user_token,
        'amount'=>'-'.$request->amount,
        'comments'=>$request->comments,
        'user_id'=>$request->user_id,
        'transaction_id' => 'REDEEM' . date('YmdHis'),
        ];
      $result = $numbers->create($data);
    //    Adding Gift Sender And Receive Details Add
        $id=$request->user_id;
        $receiverAndSenderDetails = Giftsend::where('id', $id)->get();
        if ($result) {
            return response()->json(['result' => $result,'giftCardHolderDetails'=>$receiverAndSenderDetails[0],'status' => 200, 'success' => 'Gift Cards redeem successfully'], 200);
        } else {
            return response()->json(['error' => 'Something Went Wrong Plese Contact to Admin', 'status' => 404]);
        }

 }

//   For View Statment 
/**
 * @OA\Post(
 *      tags={"Gift-Cards"},
 *     path="/gift-card-statment",
 *     summary="For Gift Statment ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="gift_card_number", type="string", example="FEMS-2024-4953"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
 public function statment(Request $request, Giftsend $giftsend, GiftcardsNumbers $numbers){
    $data=$numbers->select('giftcards_numbers.transaction_id','giftcards_numbers.user_token','giftcards_numbers.giftnumber','giftcards_numbers.amount','giftcards_numbers.comments','giftcards_numbers.updated_at')->Where('giftnumber',$request->gift_card_number)->where('user_token',$request->user_token)->get();
    // Initialize sum variable
    $totalAmount = 0;

    // Iterate over each record in the collection and sum up the 'amount' values
    foreach ($data as $record) {
        $totalAmount += $record->amount;
    }

    if ($data) {
        return response()->json(['result' => $data,'TotalAmount'=>$totalAmount, 'status' => 200, 'success' => 'Gift History Found Successfully'], 200);
    } else {
        return response()->json(['error' => 'Sory No History Found!', 'status' => 404]);
    }
 }

 


/**
 * @OA\Post(
 *      tags={"Gift-Cards"},
 *     path="/gift-purchase-from-store",
 *     summary="Gift card Purchase from store",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="amount", type="integer", example="20"),
 *                 @OA\Property(property="gift_send_for", type="string", example="Self"),
 *                 @OA\Property(property="qty", type="integer", example="20"),
 *                 @OA\Property(property="your_name", type="string", example="Deepak Prasad"),
 *                 @OA\Property(property="gift_send_to", type="email", example="deepak@thetemz.com"),
 *                 @OA\Property(property="gift_card_send_type", type="string", example="Email"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *                 @OA\Property(property="coupon_code", type="string", example="CCODE12"),
 *                 @OA\Property(property="payment_mode", type="string", example="Cash"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
public function gift_purchase (Request $request,Giftsend $giftsend,User $user,GiftCoupon $coupon,GiftcardsNumbers $cardnumber)
{
    $data=$request->all();
    if(!empty($result->recipient_name))
    {
    $data['receipt_email']=$request->receipt_email;
    }

    $data['payment_time'] = NOW();
    $result=$giftsend->create($data);

    if ($result && $result->payment_status=='succeeded') {
    $qty=$result->qty;
    for($i=1;$i<=$qty;$i++)
    {

        $randomCode = mt_rand(1000, 9999);
        $date = date('Y');
        $gift_card_code = 'FEMS-' . $date . '-' . $randomCode;
        $cardgenerate = [
            'user_id' => $result->id,
            'transaction_id' => $result->transaction_id,
            'user_token' => $result->user_token,
            'amount' => $result->amount,
            'giftnumber' => $gift_card_code,
            'status' => 1,
        ];
        $cardresult=$cardnumber->create($cardgenerate);
    }
    // Fetch the gift card number(s) based on the transaction ID from $result
    $giftcardNumber = GiftcardsNumbers::where('transaction_id', $result->transaction_id)->get();
    // Assign the fetched gift card number(s) to the result array

    $result['card_number'] = $giftcardNumber;
    $gift_send_to = $result->gift_send_to;
    $result['amount']=$result->amount*$result->qty;

    if(!empty($result->recipient_name))
    {

        Mail::to($result->receipt_email)->send(new GiftReceipt($result));
    }
    Mail::to($gift_send_to)->send(new GeftcardMail($result));

     return response()->json(['result' => $result,'status' => 200, 'success' => 'Gift Purchases Successfully And Card Number Sent on Email'], 200);
     } else {
         return response()->json(['result' => $result,'error' => 'Something Went Wrong', 'status' => 404]);
     }

}

/**
 * @OA\Post(
 *      tags={"Transaction"},
 *     path="/payment_confirmation",
 *     summary="If you are take payment without payment getway, This API use for Payment Received Confirmation(Related Information get from API: /gift-purchase-from-store)",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="id", type="integer", example="62"),
 *                 @OA\Property(property="your_name", type="string", example="Deepak Prasad"),
 *                 @OA\Property(property="gift_send_to", type="integer", example="deepakprasad224@gmail.com"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *                 @OA\Property(property="payment_mode", type="string", example="PayPal"),
 *                 @OA\Property(property="transaction_id", type="string", example="TEST-18-03-2024"),
 *                 @OA\Property(property="transaction_amount", type="string", example="100"),
 *                 @OA\Property(property="payment_status", type="string", example="succeeded,processing,payment_failed"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
public function payment_confirmation(Request $request, Giftsend $giftsend,GiftcardsNumbers $cardnumber)
{
    $validatedData = $request->validate([
        'id' => 'required',
        'gift_send_to' => 'required',
        'your_name' => 'required',
        'user_token' => 'required',
    ]);
   
    $id = $validatedData['id'];
    $giftSendTo = $validatedData['gift_send_to'];
    $yourName = $validatedData['your_name'];
    $userToken = $validatedData['user_token'];

    // $data = $request->all();
    $resultData = Giftsend::where('id', $id)
    ->where('gift_send_to', $giftSendTo)
    ->where('your_name', $yourName)
    ->where('user_token', $userToken)
    ->first();

        // echo $resultData->id; die();
    if ($resultData) {
        $resultData->transaction_id = $request->transaction_id;
        $resultData->transaction_amount = $request->transaction_amount;
        $resultData->payment_status = $request->payment_status;
        $resultData->payment_time = NOW();

        $result=$resultData->save();

        // You should check if the update was successful before trying to access its properties
        if ($result && $request->payment_status=='succeeded') {
            $get_updated_result = $giftsend->find($id);
            // print_r($get_updated_result['id']); die();
           

            $qty=$get_updated_result['qty'];
            for($i=1;$i<=$qty;$i++)
            {

                $randomCode = mt_rand(1000, 9999);
                $date = date('Y');
                $gift_card_code = 'FEMS-' . $date . '-' . $randomCode;
                $cardgenerate = [
                    'user_id' => $get_updated_result->id,
                    'transaction_id' => $get_updated_result->transaction_id,
                    'user_token' => $get_updated_result->user_token,
                    'amount' => $get_updated_result->amount,
                    'giftnumber' => $gift_card_code,
                    'status' => 1,
                ];
                $cardnumber->create($cardgenerate);
            }

            $gift_send_to = $get_updated_result->gift_send_to;
            $tomail = $get_updated_result->receipt_email;
            Mail::to($gift_send_to)->send(new GeftcardMail($get_updated_result));

        return response()->json(['status' => 200, 'success' => 'Gift Card Sent On Your Email Id.'], 200);
      
    }
    else {
        return response()->json(['error' => 'Please Check Transaction Status.Transaction does not match in our database!', 'status' => 404]);
    }
}
}


//  Code for payment status update
/**
 * @OA\Post(
 *      tags={"Transaction"},
 *     path="/payment_status_update",
 *     summary="If Payment status is Pending or Processing plese use this API for Changing Payment Status",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="id", type="integer", example="1"),
 *                 @OA\Property(property="transaction_id", type="string", example="TEST-18-03-2024"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *                 @OA\Property(property="payment_status", type="string", example="succeeded"),
 *                 @OA\Property(property="comments", type="string", example="Pending status updated against transaction number..xxxx-xxx"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */
public function payment_status_update(Request $request, Giftsend $giftsend,GiftcardsNumbers $cardnumber)
{
    $validatedData = $request->validate([
        'id' => 'required',
        'user_token' => 'required',
        'transaction_id' => 'required',
        'payment_status' => 'required',
    ]);
   
    $id = $validatedData['id'];
    $userToken = $validatedData['user_token'];
    $transaction_id = $validatedData['transaction_id'];

    // $data = $request->all();
    $resultData = Giftsend::where('id', $id)
    ->where('user_token', $userToken)
    ->where('payment_status','processing')
    ->first();

        // echo $resultData->id; die();
    if ($resultData) {
        $resultData->transaction_id = $request->transaction_id;
        $resultData->payment_status = $request->payment_status;
        $resultData->payment_time = NOW();
        $result=$resultData->save();

        // You should check if the update was successful before trying to access its properties
        if ($result && $request->payment_status=='succeeded') {
            $get_updated_result = $giftsend->find($id);
            $qty=$get_updated_result['qty'];
            for($i=1;$i<=$qty;$i++)
            {

                $randomCode = mt_rand(1000, 9999);
                $date = date('Y');
                $gift_card_code = 'FEMS-' . $date . '-' . $randomCode;
                $cardgenerate = [
                    'user_id' => $get_updated_result->id,
                    'transaction_id' => $get_updated_result->transaction_id,
                    'user_token' => $get_updated_result->user_token,
                    'amount' => $get_updated_result->amount,
                    'giftnumber' => $gift_card_code,
                    'status' => 1,
                    'comments'=>$request->comments,
                ];
                $cardnumber->create($cardgenerate);
            }

            $gift_send_to = $get_updated_result->gift_send_to;
            $tomail = $get_updated_result->receipt_email;
            Mail::to($gift_send_to)->send(new GeftcardMail($get_updated_result));

        return response()->json(['status' => 200, 'msg' => 'Gift Card Sent On Customer Email Id.'], 200);
      
    }
    else {
        return response()->json(['msg' => 'Please Check Transaction Status.Transaction does not match in our database!', 'status' => 404]);
    }
}
else {
    return response()->json(['msg' => 'Please Check Transaction Status.Transaction does not match in our database!', 'status' => 404]);
}
}




//  Code For Product Management 

//  Category Code 

/**
 * View the list of product categories.
 *
 * @OA\Post(
 *      tags={"Category Management"},
 *      path="/category-list",
 *      summary="View Category List",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Success: Product categories found"),
 *      @OA\Response(response="401", description="Unauthorized"),
 *      @OA\Response(response="403", description="Forbidden"),
 *      @OA\Response(response="404", description="Not Found: No product categories found"),
 * )
 */
public function category(Request $request)
{
    $token = $request->user_token;
    $categories = ProductCategory::where('user_token', $token)->where('cat_is_deleted', 0)->orderBy('id', 'DESC')->get();

    if ($categories->isNotEmpty()) {
        return response()->json(['result' => $categories, 'status' => 200, 'success' => 'Product categories found successfully'], 200);
    } else {
        return response()->json(['error' => 'Sorry, no categories found!', 'status' => 404]);
    }
}

/**
 * View the list of product categories.
 *
 * @OA\Get(
 *      tags={"Category Management"},
 *      path="/category/{id}",
 *      summary="View Category Id Wise",
 *      @OA\Parameter(
 *          in="path",
 *          name="id",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              example="1"
 *          )
 *      ),
 *      @OA\Parameter(
 *          in="query",
 *          required=true,
 *          name="user_token",
 *          @OA\Schema(
 *              type="string",
 *              example="FOREVER-MEDSPA"
 *          )
 *      ),
 *      @OA\Response(response="200", description="Success: Product category found"),
 *      @OA\Response(response="401", description="Unauthorized"),
 *      @OA\Response(response="403", description="Forbidden"),
 *      @OA\Response(response="404", description="Not Found: No product category found"),
 * )
 */


 public function category_view(Request $request, $id)
 {

     $token = $request->user_token;
     $category = ProductCategory::where('user_token', $token)
     ->where('cat_is_deleted', 0)
     ->where('id', $id)
     ->first();
     if ($category) { // This check is now correctly looking for a non-null value
         return response()->json(['result' => $category, 'status' => 200, 'msg' => 'Product categories found successfully'], 200);
     } else {
         return response()->json(['msg' => 'Sorry, no product category found!'.$id."-".$token, 'status' => 404], 404);
     }
 }
 
//   Category Update

/**
 * View the list of product categories.
 *
 * @OA\Post(
 *      tags={"Category Management"},
 *      path="/category-update/{id}",
 *      summary="Update Category",
 *      @OA\Parameter(
 *          in="path",
 *          name="id",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              example="1"
 *          )
 *      ),
 *      @OA\Parameter(
 *          in="query",
 *          name="user_token",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              example="FOREVER-MEDSPA"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *                  @OA\Property(
 *                      property="cat_name",
 *                      type="string",
 *                      example="Category Name"
 *                  ),
 *                  @OA\Property(
 *                      property="cat_description",
 *                      type="string",
 *                      example="About Category"
 *                  ),
 *                  @OA\Property(
 *                      property="cat_image",
 *                      type="string",
 *                      format="binary"
 *                  ),
 *                  @OA\Property(
 *                      property="cat_order_by",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                  @OA\Property(
 *                      property="meta_title",
 *                      type="string",
 *                      example="Add Meta Title"
 *                  ),
 *                  @OA\Property(
 *                      property="meta_description",
 *                      type="string",
 *                      example="Meta Description"
 *                  ),
 *                  @OA\Property(
 *                      property="meta_keywords",
 *                      type="string",
 *                      example="Meta Keywords"
 *                  ),
 *                  @OA\Property(
 *                      property="cat_is_deleted",
 *                      type="integer",
 *                      example="0"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                  @OA\Property(
 *                      property="parent_id",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Success: Product category found"),
 *      @OA\Response(response="401", description="Unauthorized"),
 *      @OA\Response(response="403", description="Forbidden"),
 *      @OA\Response(response="404", description="Not Found: No product category found"),
 * )
 */


public function category_update(Request $request, $id)
{
    $token = $request->user_token;
    $data=$request->all();    
    $category = ProductCategory::where('user_token', $token)
                               ->where('cat_is_deleted', 0)
                               ->where('id', $id)
                               ->first();

    if (!$category) {
        return response()->json(['error' => 'Sorry, no product category found!', 'status' => 404], 404);
    }

    // Update category attributes with request data
        if ($request->hasFile('cat_image')) { 
        $folder = str_replace(" ", "_", $request->user_token);
        $image = $request->file('cat_image');
        $destinationPath = '/uploads/' . $folder."/";
        $filename = $image->getClientOriginalName();
        $image->move(public_path($destinationPath), $filename);
        $data['cat_image'] = url('/').$destinationPath.$filename;
        $result=$category->update($data);
        }

        $result=$category->update($data);
        if ($result) { // This check is now correctly looking for a non-null value
            return response()->json(['status' => 200, 'msg' => 'Product category updated successfully'], 200);
        } else {
            return response()->json(['msg' => 'Sorry, Category is not updated something went wrong!'.$id."-".$token, 'status' => 404], 404);
        }

}

//  Category Create

/**
 * View the list of product categories.
 *
 * @OA\Post(
 *      tags={"Category Management"},
 *      path="/category-created",
 *      summary="Category Create",
 *      @OA\Parameter(
 *          in="query",
 *          name="user_token",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              example="FOREVER-MEDSPA"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *                  @OA\Property(
 *                      property="cat_name",
 *                      type="string",
 *                      example="Category Name"
 *                  ),
 *                  @OA\Property(
 *                      property="cat_description",
 *                      type="string",
 *                      example="About Category"
 *                  ),
 *                  @OA\Property(
 *                      property="cat_image",
 *                      type="string",
 *                      format="binary"
 *                  ),
 *                  @OA\Property(
 *                      property="cat_order_by",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                  @OA\Property(
 *                      property="meta_title",
 *                      type="string",
 *                      example="Add Meta Title"
 *                  ),
 *                  @OA\Property(
 *                      property="meta_description",
 *                      type="string",
 *                      example="Meta Description"
 *                  ),
 *                  @OA\Property(
 *                      property="meta_keywords",
 *                      type="string",
 *                      example="Meta Keywords"
 *                  ),
 *                  @OA\Property(
 *                      property="cat_is_deleted",
 *                      type="integer",
 *                      example="0"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                  @OA\Property(
 *                      property="parent_id",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Success: Product category found"),
 *      @OA\Response(response="401", description="Unauthorized"),
 *      @OA\Response(response="403", description="Forbidden"),
 *      @OA\Response(response="404", description="Not Found: No product category found"),
 * )
 */



 public function created(Request $request,ProductCategory $category)
{
    $data = $request->all();
    if ($request->hasFile('cat_image')) {
        $folder = str_replace(" ", "_", $request->user_token);
        $image = $request->file('cat_image');
        $destinationPath = '/uploads/' . $folder."/";
        $filename = $image->getClientOriginalName();
        $image->move(public_path($destinationPath), $filename);
        $data['cat_image'] = url('/').$destinationPath.$filename;
        $result = $category->create($data);
        if ($result) {
            return response()->json(['status' => 200, 'msg' => 'Product category created successfully'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong. Please try again!', 'status' => 404], 404);
        }
    }
    else{

        $result = $category->create($data);
        if ($result) {
            return response()->json(['status' => 200, 'msg' => 'Product category created successfully'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong. Please try again!', 'status' => 404], 404);
        }
    }
    
}


 
 //   Category Delete

/**
 * View the list of product categories.
 *
 * @OA\Post(
 *      tags={"Category Management"},
 *      path="/categoryDelete/{id}",
 *      summary="Category Deleted",
 *      @OA\Parameter(
 *          in="path",
 *          name="id",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              example="1"
 *          )
 *      ),
 *      @OA\Parameter(
 *          in="query",
 *          name="user_token",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              example="FOREVER-MEDSPA"
 *          )
 *      ),
 *      @OA\Response(response="200", description="Success: Product category found"),
 *      @OA\Response(response="401", description="Unauthorized"),
 *      @OA\Response(response="403", description="Forbidden"),
 *      @OA\Response(response="404", description="Not Found: No product category found"),
 * )
 */


public function categoryDelete(Request $request, $id)
{
    $token = $request->user_token;
    $category = ProductCategory::where('user_token', $token)
    ->where('id', $id)
    ->first();       
    $category['cat_is_deleted']=1;   
    if (!$category) {
        return response()->json(['msg' => 'Sorry, no product category found!', 'status' => 404], 404);
    }
    else{

        // Update category attributes with request data
        $category->update();
        return response()->json(['result' => $category, 'status' => 200, 'msg' => 'Product category deleted successfully'], 200);
    }



}


//  For Product 

/**
 * View the list of product.
 *
 * @OA\Post(
 *      tags={"Product Management"},
 *      path="/product-created",
 *      summary="Product Create",
 *      @OA\Parameter(
 *          in="query",
 *          name="user_token",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              example="FOREVER-MEDSPA"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *                  @OA\Property(
 *                      property="product_name",
 *                      type="string",
 *                      example="product_name"
 *                  ),
 *                  @OA\Property(
 *                      property="product_description",
 *                      type="string",
 *                      example="About Product"
 *                  ),
 *                  @OA\Property(
 *                      property="product_image",
 *                      type="string",
 *                      format="binary"
 *                  ),
 *                  @OA\Property(
 *                      property="product_order_by",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                    @OA\Property(
 *                      property="product_fetured",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                  @OA\Property(
 *                      property="meta_title",
 *                      type="string",
 *                      example="Add Meta Title"
 *                  ),
 *                  @OA\Property(
 *                      property="meta_description",
 *                      type="string",
 *                      example="Meta Description"
 *                  ),
 *                  @OA\Property(
 *                      property="meta_keywords",
 *                      type="string",
 *                      example="Meta Keywords"
 *                  ),
 *                  @OA\Property(
 *                      property="product_is_deleted",
 *                      type="integer",
 *                      example="0"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                  @OA\Property(
 *                      property="amount",
 *                      type="number",
 *                      format="float",
 *                      example=500.50
 *                  ),
 *                    @OA\Property(
 *                      property="discounted_amount",
 *                      type="number",
 *                      format="float",
 *                      example=100.50
 *                  ),
 *                      @OA\Property(
 *                      property="coupon_id",
 *                      type="number",
 *                      format="integer",
 *                      example=21
 *                  ),
 *                 @OA\Property(
 *                      property="cat_id",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                      @OA\Property(
 *                      property="search_keywords",
 *                      type="string",
 *                      example="This is Test"
 *                  ),
 *                      @OA\Property(
 *                      property="prerequisites",
 *                      type="string",
 *                      example="This is Test"
 *                  ),
 *                       @OA\Property(
 *                      property="short_description",
 *                      type="string",
 *                      example="This is Test"
 *                  ),
 *                      @OA\Property(
 *                      property="product_slug",
 *                      type="string",
 *                      example="product-name"
 *                  ),
 *                      @OA\Property(
 *                      property="popular_service",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                      @OA\Property(
 *                      property="session_number",
 *                      type="integer",
 *                      example="5"
 *                  ),
 *                      @OA\Property(
 *                      property="discount_rate",
 *                      type="float",
 *                      example="5"
 *                  ),
 *                      @OA\Property(
 *                      property="giftcard_redemption",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Success: Product found"),
 *      @OA\Response(response="401", description="Unauthorized"),
 *      @OA\Response(response="403", description="Forbidden"),
 *      @OA\Response(response="404", description="Not Found: No product found"),
 * )
 */


 public function productcreated(Request $request,Product $product)
 {
    $data = $request->all();
     // Create product attributes with request data
     if ($request->hasFile('product_image')) {
        $folder = str_replace(" ", "_", $request->user_token);
        $image = $request->file('product_image');
        $destinationPath = '/uploads/' . $folder."/";
        $filename = $image->getClientOriginalName();
        $image->move(public_path($destinationPath), $filename);
        $data['product_image'] = url('/').$destinationPath.$filename;
        $result = $product->create($data);
        if ($result) {
            return response()->json(['status' => 200, 'msg' => 'Product created successfully'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong. Please try again!', 'status' => 404], 404);
        }
    }
    else{
        $result = $product->create($data);
        if ($result) {
            return response()->json(['status' => 200, 'msg' => 'Product created successfully'], 200);
        } else {
            return response()->json(['msg' => 'Something went wrong. Please try again!', 'status' => 404], 404);
        }
    }
 }

 /**
 * For Product Delete
 *
 * @OA\Post(
 *      tags={"Product Management"},
 *      path="/productDelete/{id}",
 *      summary="Product Deleted",
 *      @OA\Parameter(
 *          in="path",
 *          name="id",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              example="1"
 *          )
 *      ),
 *      @OA\Parameter(
 *          in="query",
 *          name="user_token",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              example="FOREVER-MEDSPA"
 *          )
 *      ),
 *      @OA\Response(response="200", description="Success: Product found"),
 *      @OA\Response(response="401", description="Unauthorized"),
 *      @OA\Response(response="403", description="Forbidden"),
 *      @OA\Response(response="404", description="Not Found: No product found"),
 * )
 */


public function productDelete(Request $request, $id)
{
    $token = $request->user_token;                  
    $product = Product::where('user_token', $token)
                               ->where('id', $id)
                               ->first();
      $product['product_is_deleted']=1; 
    if (!$product) {
        return response()->json(['msg' => 'Sorry, no product product found!', 'status' => 404], 404);
    }

    // Update product attributes with request data

    $product->update();

    return response()->json(['result' => $product, 'status' => 200, 'msg' => 'Product Deleted Successfully'], 200);
}

// Product Update id Wise
/**
 * Product Update id Wise
 *
 * @OA\Post(
 *      tags={"Product Management"},
 *      path="/product-update/{id}",
 *      summary="Update Product",
 *      @OA\Parameter(
 *          in="path",
 *          name="id",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              example="1"
 *          )
 *      ),
 *      @OA\Parameter(
 *          in="query",
 *          name="user_token",
 *          required=true,
 *          @OA\Schema(
 *              type="string",
 *              example="FOREVER-MEDSPA"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *                  @OA\Property(
 *                      property="product_name",
 *                      type="string",
 *                      example="product_name"
 *                  ),
 *                  @OA\Property(
 *                      property="product_description",
 *                      type="string",
 *                      example="About Product"
 *                  ),
 *                  @OA\Property(
 *                      property="product_image",
 *                      type="string",
 *                      format="binary"
 *                  ),
 *                  @OA\Property(
 *                      property="product_order_by",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                    @OA\Property(
 *                      property="product_fetured",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                  @OA\Property(
 *                      property="meta_title",
 *                      type="string",
 *                      example="Add Meta Title"
 *                  ),
 *                  @OA\Property(
 *                      property="meta_description",
 *                      type="string",
 *                      example="Meta Description"
 *                  ),
 *                  @OA\Property(
 *                      property="meta_keywords",
 *                      type="string",
 *                      example="Meta Keywords"
 *                  ),
 *                  @OA\Property(
 *                      property="product_is_deleted",
 *                      type="integer",
 *                      example="0"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                  @OA\Property(
 *                      property="amount",
 *                      type="number",
 *                      format="float",
 *                      example=500.50
 *                  ),
 *                    @OA\Property(
 *                      property="discounted_amount",
 *                      type="number",
 *                      format="float",
 *                      example=100.50
 *                  ),
 *                      @OA\Property(
 *                      property="coupon_id",
 *                      type="number",
 *                      format="integer",
 *                      example=21
 *                  ),
 *                  @OA\Property(
 *                      property="cat_id",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                      @OA\Property(
 *                      property="search_keywords",
 *                      type="string",
 *                      example="This is Test"
 *                  ),
 *                      @OA\Property(
 *                      property="prerequisites",
 *                      type="string",
 *                      example="This is Test"
 *                  ),
 *                       @OA\Property(
 *                      property="short_description",
 *                      type="string",
 *                      example="This is Test"
 *                  ),
 *                      @OA\Property(
 *                      property="product_slug",
 *                      type="string",
 *                      example="product-name"
 *                  ),
 *                      @OA\Property(
 *                      property="popular_service",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                      @OA\Property(
 *                      property="session_number",
 *                      type="integer",
 *                      example="5"
 *                  ),
 *                      @OA\Property(
 *                      property="discount_rate",
 *                      type="float",
 *                      example="5"
 *                  ),
 *                      @OA\Property(
 *                      property="giftcard_redemption",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Success: Product found"),
 *      @OA\Response(response="401", description="Unauthorized"),
 *      @OA\Response(response="403", description="Forbidden"),
 *      @OA\Response(response="404", description="Not Found: No product found"),
 * )
 */
public function product_update(Request $request, $id)
{

    $token = $request->user_token;
    $data=$request->all();    
    $product = Product::where('user_token', $token)
                               ->where('product_is_deleted', 0)
                               ->where('id', $id)
                               ->first();

    if (!$product) {
        return response()->json(['error' => 'Sorry, no product  found!', 'status' => 404], 404);
    }

// Update product attributes with request data
    if ($request->hasFile('product_image')) { 
    $folder = str_replace(" ", "_", $request->user_token);
    $image = $request->file('product_image');
    $destinationPath = '/uploads/' . $folder."/";
    $filename = $image->getClientOriginalName();
    $image->move(public_path($destinationPath), $filename);
    $data['product_image'] = url('/').$destinationPath.$filename;
    $result=$product->update($data);
    }

    $result=$product->update($data);
    if ($result) { // This check is now correctly looking for a non-null value
        return response()->json(['status' => 200, 'msg' => 'Product updated successfully'], 200);
    } else {
        return response()->json(['msg' => 'Sorry, Product is not updated something went wrong!'.$id."-".$token, 'status' => 404], 404);
    }
    

    return response()->json(['result' => $product, 'status' => 200, 'success' => 'Product updated successfully'], 200);
}

//  For Product List 


/**
 * View the list of product .
 *
 * @OA\Post(
 *      tags={"Product Management"},
 *      path="/product-list",
 *      summary="View Product List",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *                  @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *              )
 *          )
 *      ),
 *      @OA\Response(response="200", description="Success: Product found"),
 *      @OA\Response(response="401", description="Unauthorized"),
 *      @OA\Response(response="403", description="Forbidden"),
 *      @OA\Response(response="404", description="Not Found: No product found"),
 * )
 */
public function product(Request $request)
{
    $token = $request->user_token;
    // $product = Product::where('user_token', $token)->where('product_is_deleted', 0)->get();
    $product = Product::join('product_categories', 'products.cat_id', '=', 'product_categories.id')
                    ->select('products.*','product_categories.cat_name')
                  ->where('products.user_token', $token)
                  ->where('products.product_is_deleted', 0)
                  ->orderBy('id', 'DESC')
                  ->get();

    if ($product->isNotEmpty()) {
        return response()->json(['result' => $product, 'status' => 200, 'success' => 'Product  found successfully'], 200);
    } else {
        return response()->json(['error' => 'Sorry, no product  found!', 'status' => 404]);
    }
}

//  Product view
/**
 * View the list of product categories.
 *
 * @OA\Get(
 *      tags={"Product Management"},
 *      path="/product/{id}",
 *      summary="View Product Id Wise",
 *      @OA\Parameter(
 *          in="path",
 *          name="id",
 *          required=true,
 *          @OA\Schema(
 *              type="integer",
 *              example="1"
 *          )
 *      ),
 *      @OA\Parameter(
 *          in="query",
 *          required=true,
 *          name="user_token",
 *          @OA\Schema(
 *              type="string",
 *              example="FOREVER-MEDSPA"
 *          )
 *      ),
 *      @OA\Response(response="200", description="Success: Product found"),
 *      @OA\Response(response="401", description="Unauthorized"),
 *      @OA\Response(response="403", description="Forbidden"),
 *      @OA\Response(response="404", description="Not Found: No product found"),
 * )
 */

public function product_view(Request $request, $id)
{
    $token = $request->user_token;
    $product = Product::where('user_token', $token)
        ->where('product_is_deleted', 0)
        ->where('id', $id)
        ->first();
    if ($product !== null) { // Check for non-null to ensure a product was found
        return response()->json(['result' => $product,'status' => 200, 'success' => 'Product found successfully'], 200);
    } else {
        return response()->json(['error' => 'Sorry, no product found!', 'status' => 404], 404);
    }
}


//  for Giftcards cancel
/**
 * @OA\Post(
 *      tags={"Gift-Cards"},
 *     path="/giftcard-cancel",
 *     summary="For Gift Cancel ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="gift_card_number", type="string", example="FEMS-2024-8147"),
 *                 @OA\Property(property="comments", type="string", example="I Want To Cancel My Giftcard"),
 *                 @OA\Property(property="user_id", type="integer", example="6"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */

 public function cancelgiftcard(Request $request,GiftcardsNumbers $numbers){
    $canceldata=[
        'giftnumber'=>$request->gift_card_number,
        'user_token'=>$request->user_token,
        'comments'=>$request->comments,
        'user_id'=>$request->user_id,
        'status'=>0,
        'transaction_id' => 'CANCEL' . date('YmdHis'),
        ];
      $result = $numbers->create($canceldata);
      $updateResult=$numbers->where('giftnumber', $request->gift_card_number)
      ->where('user_id', $request->user_id)
      ->update(['status' => 0]);
           
      $receiverAndSenderDetails = Giftsend::where('id', $request->user_id)->get();
      $receiverAndSenderDetails['gift_card_number']=$request->gift_card_number;
        if ($result && $updateResult && $receiverAndSenderDetails) {

            return response()->json(['status' => 200,'receiverAndSenderDetails'=>$receiverAndSenderDetails,'success' => $request->gift_card_number.' Gift Cards Canceled successfully'], 200);
        } else {
            return response()->json(['error' => 'Something Went Wrong Plese Contact to Admin', 'status' => 404]);
        }

 }

 // Order Search
/**
 * @OA\Post(
 *      tags={"Order Details"},
 *     path="/order-search",
 *     summary="For Order Search ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="order_id", type="string", example="ORD-66c46b7083b2b-jq0Z2"),
 *                 @OA\Property(property="email", type="string", example="deepak@thetemz.com"),
 *                 @OA\Property(property="phone", type="string", example="0987654321"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */

 public function OrderSearch(Request $request)
{
    $token = $request->user_token;
    $order_id = $request->order_id;
    $email = $request->email;
    $phone = $request->phone;

    // Start the query with necessary joins and selections
    $query = DB::table('transaction_histories')
        ->join('service_orders', 'service_orders.order_id', '=', 'transaction_histories.order_id')
        ->join('products', 'products.id', '=', 'service_orders.service_id')
        ->leftJoin('service_redeems', function($join) {
            $join->on('service_redeems.order_id', '=', 'service_orders.order_id')
                 ->on('service_redeems.service_id', '=', 'service_orders.service_id');
        })
        ->select(
            'products.product_name',
            'service_orders.number_of_session',
            'transaction_histories.email',
            'transaction_histories.phone',
            'transaction_histories.fname',
            'transaction_histories.lname',
            'transaction_histories.order_id',
            'service_orders.service_id',
            DB::raw('IFNULL(SUM(service_redeems.number_of_session_use), 0) as total_redeemed_sessions'),
            DB::raw('(service_orders.number_of_session - IFNULL(SUM(service_redeems.number_of_session_use), 0)) as remaining_sessions'),
            'service_orders.discounted_amount',
            'service_orders.actual_amount',
            // Correct calculation for refund_amount
            DB::raw('(service_orders.discounted_amount - (service_orders.actual_amount / service_orders.number_of_session) * IFNULL(SUM(service_redeems.number_of_session_use), 0)) as refund_amount')
            //          Discounted Amount-Actualamount/

        )
        ->groupBy(
            'products.product_name',
            'service_orders.number_of_session',
            'transaction_histories.email',
            'transaction_histories.phone',
            'transaction_histories.fname',
            'transaction_histories.lname',
            'transaction_histories.order_id',
            'service_orders.service_id',
            'service_orders.discounted_amount',
            'service_orders.actual_amount'
        );

    // Apply filters based on the request
    if (!empty($email)) {
        $query->where('transaction_histories.email', 'like', '%' . $email . '%');
    }

    if (!empty($phone)) {
        $query->where('transaction_histories.phone', 'like', '%' . $phone . '%');
    }

    if (!empty($order_id)) {
        $query->where('service_orders.order_id', $order_id);
    }

    // Filter by user token
    $query->where('service_orders.user_token', $token);

    // Get the results without pagination
    $results = $query->get();

    if ($results->isNotEmpty()) {
        return response()->json(['result' => $results, 'status' => 200, 'success' => 'Order Details Found'], 200);
    } else {
        return response()->json(['error' => 'Order Details Not Found', 'status' => 404]);
    }
}




//  for Service Redeem
/**
 * @OA\Post(
 *      tags={"Order Details"},
 *     path="/service-redeem",
 *     summary="For Service Redeem ",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="order_id", type="string", example="ORD-66c4697701bed-JQZAn"),
 *                 @OA\Property(property="comments", type="string", example="I Want To Redeem My Service"),
 *                 @OA\Property(property="number_of_session", type="flout", example="1"),
 *                 @OA\Property(property="service_id", type="integer", example="1"),
 *                 @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *             )
 *         )
 *     ),
 *     @OA\Response(response="200", description="Result Found"),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */

 public function ServiceRedeem(Request $request, Giftsend $giftsend, GiftcardsNumbers $numbers){
    $data=[
        'giftnumber'=>$request->gift_card_number,
        'user_token'=>$request->user_token,
        'amount'=>'-'.$request->amount,
        'comments'=>$request->comments,
        'user_id'=>$request->user_id,
        'transaction_id' => 'REDEEM' . date('YmdHis'),
        ];
      $result = $numbers->create($data);
    //    Adding Gift Sender And Receive Details Add
        $id=$request->user_id;
        $receiverAndSenderDetails = Giftsend::where('id', $id)->get();
        if ($result) {
            return response()->json(['result' => $result,'giftCardHolderDetails'=>$receiverAndSenderDetails[0],'status' => 200, 'success' => 'Service redeem successfully'], 200);
        } else {
            return response()->json(['error' => 'Something Went Wrong Plese Contact to Admin', 'status' => 404]);
        }

 }

 //  for Deals Search
/**
 * @OA\Post(
 *      tags={"Order Details"},
 *      path="/deals-search",
 *      summary="For Service Redeem",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *                  type="object",
 *                  required={"cat_name", "user_token"},
 *                  @OA\Property(property="cat_name", type="string", example="September Deals"),
 *                  @OA\Property(property="user_token", type="string", example="FOREVER-MEDSPA"),
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Result Found",
 *          @OA\JsonContent(
 *              @OA\Property(property="result", type="array", @OA\Items(type="object")),
 *              @OA\Property(property="status", type="integer", example=200),
 *              @OA\Property(property="success", type="string", example="Deals Found")
 *          )
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="No deals found",
 *          @OA\JsonContent(
 *              @OA\Property(property="error", type="string", example="No deals found"),
 *              @OA\Property(property="status", type="integer", example=404)
 *          )
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *          @OA\JsonContent(
 *              @OA\Property(property="error", type="string", example="Unauthenticated"),
 *              @OA\Property(property="status", type="integer", example=401)
 *          )
 *      ),
 *      @OA\Response(
 *          response=403,
 *          description="Forbidden",
 *          @OA\JsonContent(
 *              @OA\Property(property="error", type="string", example="Forbidden"),
 *              @OA\Property(property="status", type="integer", example=403)
 *          )
 *      )
 * )
 */
public function DealsSearch(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'cat_name' => 'required|string',
        'user_token' => 'required|string',
        'page' => 'nullable|integer|min:1',
        'limit' => 'nullable|integer|min:1|max:100',
    ]);

    $page = $validated['page'] ?? 1;
    $limit = $validated['limit'] ?? 10;

    $query = ProductCategory::where('user_token', $validated['user_token'])
                ->where(function ($query) use ($validated) {
                    $query->where('cat_name', 'LIKE', '%' . $validated['cat_name'] . '%')
                          ->orWhere('slug', 'LIKE', '%' . $validated['cat_name'] . '%');
                });

    $total = $query->count(); // Get total number of items

    $result = $query->skip(($page - 1) * $limit)
                    ->take($limit)
                    ->get();

    // Return response
    if ($result->isNotEmpty()) {
        return response()->json([
            'data' => $result,
            'status' => 200,
            'success' => 'Deals Found',
            'total' => $total,
            'page' => $page,
            'limit' => $limit
        ], 200);
    } else {
        return response()->json([
            'error' => 'No deals found',
            'status' => 404
        ], 404);
    }
}




}

