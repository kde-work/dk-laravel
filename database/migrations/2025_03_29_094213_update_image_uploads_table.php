<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateImageUploadsTable extends Migration
{
    public function up()
    {
        Schema::table('image_uploads', function (Blueprint $table) {
            $table->string('path')->nullable(); // Путь к оригинальному изображению
            $table->json('processed_paths')->nullable(); // Пути к обработанным изображениям (WebP, AVIF и т.д.)
            $table->boolean('processed')->default(false); // Статус обработки
        });
    }

    public function down()
    {
        Schema::table('image_uploads', function (Blueprint $table) {
            $table->dropColumn(['path', 'processed_paths', 'processed']);
        });
    }
}
