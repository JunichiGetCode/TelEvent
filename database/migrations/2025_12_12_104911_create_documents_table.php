<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Membuat tabel documents
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->string('type', 100);
            $table->string('file_path');
            $table->timestamps();
        });

        // Menambahkan kolom baru jika belum ada
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'new_column')) {
                $table->string('new_column')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
