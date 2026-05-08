<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Menjalankan migrasi untuk membuat tabel events.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relasi ke user

            $table->string('type');
            $table->string('title');
            $table->date('start_date')->nullable(); // Kasih nullable biar aman
            $table->date('end_date')->nullable();   // Kasih nullable biar aman

            // Kolom untuk file upload
            $table->string('proposal');
            $table->string('poster');
            $table->string('timeline');
            $table->string('budgeting');
            
            // PENTING: other_data harus nullable karena sifatnya opsional
            $table->string('other_data')->nullable(); 

            // PENTING: Ini kolom status yang bikin error tadi
            // Kita pakai string biasa dan default 'pending'
            $table->string('status')->default('pending');

            $table->timestamps();

            // Relasi ke user, dengan tindakan cascading delete
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Membatalkan migrasi dengan menghapus tabel events.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}