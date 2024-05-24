<?php

namespace App\Http\Controllers;

use App\Models\GiftCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GiftCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=GiftCategory::OrderBy('id','DESC')->get();
        return view('giftcategory.index',compact('data'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('giftcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,GiftCategory $category)
    {
        $data=$request->all();
        $category->create($data);
        return redirect()->route('gift-category.index')->with('message','Category Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GiftCategory  $giftCategory
     * @return \Illuminate\Http\Response
     */
    public function show(GiftCategory $giftCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GiftCategory  $giftCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(GiftCategory $giftCategory)
    {
        return view('giftcategory.create',compact('giftCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GiftCategory  $giftCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GiftCategory $giftCategory)
    {
        $data=$request->all();
        $giftCategory->update($data);
        return redirect()->route('gift-category.index')->with('message','Category Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GiftCategory  $giftCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(GiftCategory $giftCategory)
    {
        $giftCategory->delete();
        return back()->with('message', 'Category Deleted Successfully');
    }
}
