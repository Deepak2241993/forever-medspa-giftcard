<?php

namespace App\Http\Controllers;

use App\Models\PopularOffer;
use Illuminate\Http\Request;

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
    public function Checkout(){
        return view('product.checkout');
    }
    public function Cart(){
        return view('product.cart');
    }
}
