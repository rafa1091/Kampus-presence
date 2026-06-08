<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('hari');
            $table->time('mulai');
            $table->time('selesai');
            $table->string('aktivitas');
            $table->string('matakuliah')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};