<?php

namespace App\Http\Controllers;

use App\Models\PopularOffer;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PopularOfferController extends Controller
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

    public function Checkout(){
        $cart = session()->get('cart', []);
        // $totalAmount = $this->calculateTotalAmount($cart);
        return view('product.checkout',compact('cart'));
    }

    

}
