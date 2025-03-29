<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsermetaTable extends Migration
{
    public function up()
    {
        Schema::create('usermeta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Связь с пользователем
            $table->string('key'); // Ключ метаданных
            $table->text('value')->nullable(); // Значение метаданных
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usermeta');
    }
}
