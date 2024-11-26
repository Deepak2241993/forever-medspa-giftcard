<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\ProductCategory;
use App\Models\ServiceUnit;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import Log facade
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Banner $b)
    {
        $result =Banner::all();
        return view('admin.banners.index',compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unit = ServiceUnit::where('product_is_deleted', 0)
        ->where('status', 1)
        ->get();

        $services = Product::where('product_is_deleted', 0)
        ->where('status', 1)
        ->get();

        return view('admin.banners.create',compact('unit','services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Banner $banner)
{
    // Log request data for debugging
    Log::info('Banner store request received', ['request_data' => $request->all()]);

    // Add validation rules for file size (less than 1 MB) and image type
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024', // Max size in KB (1024 KB = 1 MB)
    ]);

    $data = $request->all();
 
   

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageSize = getimagesize($image); // Get image dimensions
        $fileSize = $image->getSize(); // Get file size in bytes
    
        // File size constraints
        $minSize = 10 * 1024; // 10 KB in bytes
        $maxSize = 2 * 1024 * 1024; // 2 MB in bytes
    
        // Check if the file meets size and dimension requirements
        if ($fileSize >= $minSize && $fileSize <= $maxSize && $imageSize[0] <= 1349 && $imageSize[1] <= 550) {
            $destinationPath = '/sliders/';
            $filename = time() . '_' . $image->getClientOriginalName(); // Adding timestamp to avoid filename conflicts
    
            // Log image details before moving
            Log::info('Uploading image', [
                'filename' => $filename,
                'width' => $imageSize[0],
                'height' => $imageSize[1],
                'size_in_kb' => round($fileSize / 1024, 2),
                'destination' => public_path($destinationPath)
            ]);
    
            $image->move(public_path($destinationPath), $filename);
            $data['image'] = url('/') . $destinationPath . $filename;
    
            // Log successful image upload
            Log::info('Image successfully uploaded', ['image_url' => $data['image']]);
        } else {
            // Prepare error messages
            $errors = [];
            if ($fileSize < $minSize) {
                $errors[] = 'Image size must be at least 10 KB.';
            }
            if ($fileSize > $maxSize) {
                $errors[] = 'Image size must not exceed 2 MB.';
            }
            if ($imageSize[0] > 1349 || $imageSize[1] > 550) {
                $errors[] = 'Image dimensions should not exceed 1349x550 pixels.';
            }
    
            Log::error('Image upload failed', ['errors' => $errors]);
    
            // Redirect back to the form with error messages
            return redirect()->back()->withErrors([
                'image' => implode(' ', $errors)
            ])->withInput();
        }
    } else {
        // Handle case where no file is uploaded
        return redirect()->back()->withErrors([
            'image' => 'No image file was uploaded.'
        ])->withInput();
    }
    
    
    // dd($data);
    $result = $banner->create($data);
    if ($result) {
        // Log success
        Log::info('Banner successfully created', ['banner_data' => $data]);
        return redirect(route('banner.index'))->with(['success' => 'Slider is created successfully']);;
    } else {
        // Log failure
        Log::error('Failed to create banner', ['banner_data' => $data]);
        return back()->with(['error' => 'Image dimensions should not exceed 1349x550 pixels.']);;
    }
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        $unit = ServiceUnit::where('product_is_deleted', 0)
        ->where('status', 1)
        ->get();


        $services = Product::where('product_is_deleted', 0)
        ->where('status', 1)
        ->get();
        return view('admin.banners.create',compact('banner','unit','services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024', // Max size in KB (1024 KB = 1 MB)
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageSize = getimagesize($image); // Get image dimensions
    
            // Check if the width and height meet the required dimensions
            if ($imageSize[0] <= 1349 && $imageSize[1] <= 550) {
                $destinationPath = '/sliders/';
                $filename = $image->getClientOriginalName();
                $image->move(public_path($destinationPath), $filename);
                $data['image'] = url('/').$destinationPath.$filename;
            } else {
                return back()->withErrors(['image' => 'Image dimensions should not exceed 1349x550 pixels.']);
            }
        $banner->update($data);
        return redirect(route('banner.index'))->with('message','Slider Updated Successfully');
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect(route('banner.index'))->with('message','Slider deleted successfully');
    }
}
