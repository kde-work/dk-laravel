<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('age')->nullable();
            $table->float('height')->nullable();
            $table->boolean('children')->default(false);
            $table->string('photo')->nullable();
            $table->json('photos')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('chatId')->nullable();
            $table->boolean('hasChat')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'age',
                'height',
                'children',
                'photo',
                'photos',
                'birthdate',
                'chatId',
                'hasChat'
            ]);
        });
    }
};