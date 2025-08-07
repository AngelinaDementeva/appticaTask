<?php

namespace App\Services;

use App\Models\TopCategoryPosition;
use Illuminate\Support\Facades\Http;

class AppTopCategoryService
{
    private int $application_id = 1421444;
    private int $country_id = 1;
    private string $api_key = 'fVN5Q9KVOlOHDx9mOsKPAQsFBlEhBOwguLkNEDTZvKzJzT3l';

    public function fetchAndSave(string $date): void
    {
        $url = "https://api.apptica.com/package/top_history/{$this->application_id}/{$this->country_id}";
        
        $response = Http::get($url, [
            'date_from' => $date,
            'date_to' => $date,
            'B4NKGg' => $this->api_key,
        ]);
        
        if ($response->failed()) {
            throw new \Exception('Ошибка загрузки данных с Apptica: ' . $response->status());
        }
        
        $data = $response->json();

        if (!isset($data['data']) || !is_array($data['data'])) {
            throw new \Exception('Некорректный ответ от Apptica');
        }

        $category_positions = [];

        foreach ($data['data'] as $category => $subcategories) {
            foreach ($subcategories as $subcategory => $dates) {
                foreach ($dates as $date_key => $position) {
                    if (!isset($category_positions[$category]) || $position < $category_positions[$category]) {
                        $category_positions[$category] = $position;
                    }
                }
            }
        }

        foreach ($category_positions as $category => $position) {
            TopCategoryPosition::updateOrCreate(
                ['date' => $date, 'category' => $category],
                ['position' => $position]
            );
        }
    }
}
