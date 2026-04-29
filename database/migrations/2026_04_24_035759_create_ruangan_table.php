<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruangan');        // ex: "R. 201", "Lab Komputer"
            $table->string('kode_ruangan')->unique(); // ex: "R201"
            $table->string('gedung')->nullable();
            $table->integer('lantai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('ruangan');
    }
};