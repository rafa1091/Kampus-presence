<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            if (!Schema::hasColumn('dosen', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')
                      ->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('dosen', 'status')) {
                $table->enum('status', ['di_ruangan','mengajar','bimbingan','tidak_ada'])
                      ->default('tidak_ada')->after('email');
            }
            if (!Schema::hasColumn('dosen', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('status');
            }
            if (!Schema::hasColumn('dosen', 'foto')) {
                $table->string('foto')->nullable()->after('no_hp');
            }
            if (!Schema::hasColumn('dosen', 'catatan')) {
                $table->string('catatan')->nullable()->after('foto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id','status','no_hp','foto','catatan']);
        });
    }
};