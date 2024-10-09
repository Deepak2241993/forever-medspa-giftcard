<?php

namespace App\Http\Controllers;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class CategoryExportController extends Controller
{
    public function exportCategories(Request $request)
    {
        // Fetch data from product_categories table
        $categories = ProductCategory::select(
            'id', 'cat_name','status'
        )->get();

        // Prepare CSV headers
        $csvHeader = [
            'ID', 'Deals Name','Active Status'
        ];

        // Open a file pointer for output
        $fileName = "deals.csv";
        $output = fopen('php://output', 'w');

        // Write CSV header
        fputcsv($output, $csvHeader);

        // Write the data rows to the CSV
        foreach ($categories as $category) {
            $status = $category->status == 1 ? 'Yes' : 'No';
            fputcsv($output, [
                $category->id,
                $category->cat_name,
                $status,
            ]);
        }

        fclose($output);

        // Create a response with CSV headers
        return Response::make('', 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }
}
