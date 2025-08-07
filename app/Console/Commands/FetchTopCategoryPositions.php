<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AppTopCategoryService;

class FetchTopCategoryPositions extends Command
{
    protected $signature = 'appTopCategory:fetch {date}';
    protected $description = 'Fetch and save top category positions for given date';

    public function handle(AppTopCategoryService $appTopCategoryService)
    {
        $target_date = $this->argument('date');

        try {
            $appTopCategoryService->fetchAndSave($target_date);
            $this->info("Данные за дату {$target_date} успешно загружены и сохранены.");
        } catch (\Exception $exception) {
            $this->error('Ошибка: ' . $exception->getMessage());
        }
    }
}
