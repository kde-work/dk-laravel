<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFiltersTableAddFiltersTypeId extends Migration
{
    public function up(): void
    {
        Schema::table('filters', function (Blueprint $table) {
            $table->foreignId('filters_type_id')->constrained('filters_types')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('filters', function (Blueprint $table) {
            $table->dropForeign(['filters_type_id']);
            $table->dropColumn('filters_type_id');
        });
    }
}
