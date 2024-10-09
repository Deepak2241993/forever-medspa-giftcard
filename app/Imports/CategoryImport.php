<?php

namespace App\Imports;

use App\Models\ProductCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class CategoryImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Normalize the keys for case-insensitivity
        $row = array_change_key_case($row, CASE_LOWER);

        // Check for missing 'cat_name' and log if skipped
        if (empty($row['deal_name'])) {
            Log::channel('import')->warning('Row skipped: Missing Deal Name', ['row' => $row]);
            return null; // Skip this row
        }

        // Parse date formats, log if there's an issue
        $dealStartDate = $this->parseDate($row['deal_start_date'], $row);
        $dealEndDate = $this->parseDate($row['deal_end_date'], $row);

        $createdAt = now()->format('Y-m-d H:i:s');
        $updatedAt = now()->format('Y-m-d H:i:s');

        // Create or update the record
        return ProductCategory::updateOrCreate(
            ['id' => $row['id'] ?? null],
            [
                'cat_name' => $row['deal_name'] ?? null,
                'cat_description' => $row['deal_description'] ?? null,
                'cat_image' => isset($row['deal_image']) ? url('/storage/images')."/".$row['deal_image'] : null,
                'cat_is_deleted' => (int) ($row['cat_is_deleted'] ?? 0),
                'user_token' => 'FOREVER-MEDSPA',
                'status' => (int) ($row['status'] ?? 1),
                'slug' => Str::slug($row['deal_name'], '-'),
                'deal_start_date' => $dealStartDate ?? now(),
                'deal_end_date' => $dealEndDate ?? now(),
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]
        );
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
