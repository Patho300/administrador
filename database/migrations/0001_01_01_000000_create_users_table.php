<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    
    public function up(): void
    {
        Schema::dropIfExists('users'); // Agrega esta línea
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // int UNSIGNED AUTO_INCREMENT
            $table->string('name', 60);
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->integer('user_level'); // 1=Admin, 2=Bodega, 3=Usuario
            $table->string('image', 255)->default('no_image.jpg');
            $table->tinyInteger('status')->default(1); // 1=Activo, 0=Inactivo
            $table->datetime('last_login')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
