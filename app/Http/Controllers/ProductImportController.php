<?php

namespace App\Http\Controllers;
use App\Imports\ProductImporter;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class ProductImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new ProductImporter, $request->file('file'));

        return redirect()->back()->with('success', 'Services imported successfully!');
    }
}
