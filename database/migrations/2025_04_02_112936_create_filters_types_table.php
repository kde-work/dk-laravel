<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltersTypesTable extends Migration
{
    public function up(): void
    {
        Schema::create('filters_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название типа фильтра (например, checkbox, select, int)
            $table->string('validation'); // Правила валидации для типа
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filters_types');
    }
}
