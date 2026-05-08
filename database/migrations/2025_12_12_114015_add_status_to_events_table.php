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
        // Cek dulu: Jika kolom 'status' TIDAK ADA di tabel 'events', baru buat kolomnya.
        if (!Schema::hasColumn('events', 'status')) {
            Schema::table('events', function (Blueprint $table) {
                $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])
                      ->default('draft')
                      ->after('id'); // Opsional: meletakkan kolom setelah ID agar rapi
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Fitur rollback: Hapus kolom jika migrasi dibatalkan
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};