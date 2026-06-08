<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    // Tambahkan baris if ini di paling luar
    if (!Schema::hasTable('ruangan')) {
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruangan');
            $table->string('kode_ruangan');
            $table->string('gedung')->nullable();
            $table->integer('lantai')->nullable();
            $table->timestamps();
        });
    }
}

    public function down(): void {
        Schema::dropIfExists('ruangan');
    }
};