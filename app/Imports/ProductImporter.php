<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProductImporter implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $row = array_change_key_case($row, CASE_LOWER);
        // Skip if cat_name, status, or user_token are missing
        if (empty($row['service_name'])) {
            return null; // Skip this row
        }

        // Parse date formats flexibly
        $createdAt = now()->format('Y-m-d H:i:s');
        $updatedAt = now()->format('Y-m-d H:i:s');
        // $updatedAt = $this->parseDateTime($row['updated_at'], 'Y-m-d H:i:s');

        return Product::updateOrCreate(
            ['id' => $row['id'] ?? null], // The unique key to check for
            [
                'product_name' => $row['service_name'] ?? null,
                'product_slug' => Str::slug($row['service_name'], '-'),
                'short_description' => $row['short_description'] ?? null,
                'product_description' => $row['service_description'] ?? null,
                'prerequisites' => $row['prerequisites'] ?? null,
                'product_image' => isset($row['service_image']) ? url('/storage/images')."/".$row['service_image'] : null,
                // 'meta_title' => $row['meta_title'] ?? null,
                // 'meta_description' => $row['meta_description'] ?? null,
                // 'meta_keywords' => $row['meta_keywords'] ?? null,
                'product_is_deleted' => 0,
                'user_token' => 'FOREVER-MEDSPA',
                'status' => 1,
                'amount' => $row['service_original_price'] ?? null,
                'discounted_amount' => $row['service_price'] ?? null,
                'session_number' => $row['number_of_session'] ?? 1,
                'cat_id' => $row['enter_deals_id'] ?? 1,
                'search_keywords' => $row['search_keywords'] ?? 1,
                'popular_service' => Str::lower($row['popular_services_yes_no']) == 'yes' ? 1 : 0,
                'giftcard_redemption' => Str::lower($row['giftcard_redeem_yes_no']) == 'yes' ? 1 : 0,
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
