<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sensor_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruangan_id')->constrained('ruangan')->cascadeOnDelete();
            $table->enum('status', ['ada', 'tidak_ada']); // hasil deteksi PIR
            $table->timestamp('detected_at');              // waktu sensor mendeteksi
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sensor_logs');
    }
};