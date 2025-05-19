<?php 
namespace App\Imports;

use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MenuImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    public function collection(Collection $rows)
    {    
        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
               
                if (empty($row['food_name']) || empty($row['food_category'])) {
                    continue; // Skip invalid rows early
                }

                // Find or create category
                $category = Category::firstOrCreate([
                    'name' => trim($row['food_category']),
                    'description' => trim($row['food_description'])
                ]);

                $menuType = MenuType::firstOrCreate([
                    'name' => trim($row['food_category']),
                    'description' => trim($row['food_description'])
                ]);


                // Create menu item
                Menu::create([
                    'name' => trim($row['food_name']),
                    'description' => $row['food_description'] ?? null,
                    'category_id' => $category->id,
                    // 'display_on' => $row['display_on'] ?? 1,
                    // 'preparation_time' => $row['preparation_time_minutes'] ?? null,
                    'menu_type_id' =>  $menuType->id,
                    'price_options' => json_encode($this->addPriceOptions($row)),
                    'is_imported' => 1,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            report($e); // Log the error
            throw $e;
        }
    }

    public function rules(): array
    {
        return [
            'food_name' => 'required|string|max:255',
            'food_category' => 'required|string|max:255',
            'food_description' => 'nullable|string',
            '*.price' => 'nullable|string',
            'display_on' => 'nullable|integer',
            'preparation_time_minutes' => 'nullable|integer|min:0',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'food_name.required' => 'The food name is required.',
            'food_category.required' => 'The food category is required.',
            '*.price.numeric' => 'All prices must be numeric values.',
            'preparation_time_minutes.integer' => 'Preparation time must be a number in minutes.',
        ];
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    private function addPriceOptions($row): array
    {
        $data = [];

        for ($i = 1; $i <= 3; $i++) {
            $priceKey = "{$i}_price";
            $priceNameKey = "{$i}_price_name";

            if (isset($row[$priceKey]) && !empty($row[$priceKey])) {
                $data[] = [
                    'name' => $row[$priceNameKey] ?? "Option {$i}",
                    'price' => $this->normalizePrice($row[$priceKey]),
                ];
            }
        }

        return $data;
    }

    private function normalizePrice($price)
    {
        $price = preg_replace('/[^0-9.,]/', '', $price);
        $price = str_replace(',', '.', $price);
        return (float) $price;
    }
}
