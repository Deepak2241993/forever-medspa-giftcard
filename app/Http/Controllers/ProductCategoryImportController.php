<?php

namespace App\Http\Controllers;
use App\Imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class ProductCategoryImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new CategoryImport, $request->file('file'));

        return redirect()->back()->with('success', 'Categories imported successfully!');
    }
}
