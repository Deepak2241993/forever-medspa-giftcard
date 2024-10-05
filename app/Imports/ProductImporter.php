<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;

class ProductImporter implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Skip if cat_name, status, or user_token are missing
        if (empty($row['product_name']) || empty($row['user_token']) || empty($row['status'])) {
            return null; // Skip this row
        }

        // Parse date formats flexibly
        $createdAt = now()->format('Y-m-d H:i:s');
        $updatedAt = now()->format('Y-m-d H:i:s');
        // $updatedAt = $this->parseDateTime($row['updated_at'], 'Y-m-d H:i:s');

        return Product::updateOrCreate(
            ['id' => $row['id'] ?? null], // The unique key to check for
            [
                'product_name' => $row['product_name'] ?? null,
                'product_slug' => $row['product_slug'] ?? null,
                'short_description' => $row['short_description'] ?? null,
                'product_description' => $row['product_description'] ?? null,
                'prerequisites' => $row['prerequisites'] ?? null,
                'product_image' => $row['product_image'] ?? null,
                // 'meta_title' => $row['meta_title'] ?? null,
                // 'meta_description' => $row['meta_description'] ?? null,
                // 'meta_keywords' => $row['meta_keywords'] ?? null,
                'product_is_deleted' => (int) ($row['cat_is_deleted'] ?? 0),
                'user_token' => $row['user_token'] ?? null,
                'status' => (int) ($row['status'] ?? 1),
                'amount' => $row['amount'] ?? null,
                'discounted_amount' => $row['discounted_amount'] ?? null,
                'session_number' => $row['session_number'] ?? 1,
                'cat_id' => $row['cat_id'] ?? 1,
                'search_keywords' => $row['search_keywords'] ?? 1,
                'popular_service' => $row['popular_service'] ?? 1,
                'giftcard_redemption' => $row['giftcard_redemption'] ?? 1,
                'created_at' => $createdAt ?? now(),
                'updated_at' => $updatedAt ?? now(),
            
        ]);
    }

    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            // Attempt multiple date formats
            return Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null; // Skip if the format doesn't match
        }
    }

    // Function to parse date and time
    private function parseDateTime($dateTime, $format)
    {
        if (empty($dateTime)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('d-m-Y H:i', $dateTime)->format($format);
        } catch (\Exception $e) {
            return null; // Skip if the format doesn't match
        }
    }
}
