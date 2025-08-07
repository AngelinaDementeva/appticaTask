<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('top_category_positions', function (Blueprint $table) {
        $table->id();
        $table->date('date');
        $table->integer('category');
        $table->integer('position');
        $table->timestamps();

        $table->unique(['date', 'category']); // чтобы не было дубликатов
    });
}

};
