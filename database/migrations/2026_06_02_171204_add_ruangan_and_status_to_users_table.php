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
    Schema::table('users', function (Blueprint $table) {
        $table->string('ruangan')->nullable()->after('email');
        $table->string('status')->default('sedang_mengajar')->after('ruangan');
        $table->string('catatan_status')->nullable()->after('status');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['ruangan', 'status', 'catatan_status']);
    });
}
};
