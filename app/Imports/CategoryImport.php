<?php

namespace App\Imports;

use App\Models\ProductCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;

class CategoryImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Skip if cat_name, status, or user_token are missing
        if (empty($row['cat_name']) || empty($row['user_token']) || empty($row['status'])) {
            return null; // Skip this row
        }

        // Parse date formats flexibly
        $dealStartDate = $this->parseDate($row['deal_start_date']);
        $dealEndDate = $this->parseDate($row['deal_end_date']);
        $createdAt = $this->parseDateTime($row['created_at'], 'Y-m-d H:i:s');
        $updatedAt = $this->parseDateTime($row['updated_at'], 'Y-m-d H:i:s');

        return ProductCategory::updateOrCreate(
            ['id' => $row['id'] ?? null], // The unique key to check for
            [
                'cat_name' => $row['cat_name'] ?? null,
                'cat_description' => $row['cat_description'] ?? null,
                'cat_image' => $row['cat_image'] ?? null,
                'meta_title' => $row['meta_title'] ?? null,
                'meta_description' => $row['meta_description'] ?? null,
                'meta_keywords' => $row['meta_keywords'] ?? null,
                'cat_is_deleted' => (int) ($row['cat_is_deleted'] ?? 0),
                'user_token' => $row['user_token'] ?? null,
                'status' => (int) ($row['status'] ?? 1),
                'slug' => $row['slug'] ?? null,
                'deal_start_date' => $dealStartDate ?? now(),
                'deal_end_date' => $dealEndDate ?? now(),
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
