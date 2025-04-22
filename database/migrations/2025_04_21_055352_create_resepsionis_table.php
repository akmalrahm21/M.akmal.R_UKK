<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('resepsionis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kamar_id')->constrained('kamars')->onDelete('cascade');
            $table->string('nama');
            $table->string('email');
            $table->string('telepon');
            $table->integer('jumlah_orang');
            $table->integer('jumlah_pesan');
            $table->date('checkin');
            $table->date('checkout');
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status', ['pending', 'memesan'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resepsionis');
    }
};


