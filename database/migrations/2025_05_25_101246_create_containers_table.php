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
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->string('container_number')->unique(); // Nomor kontainer
            $table->string('jpt'); // JPT (Jenis Pelayanan Terminal)
            $table->datetime('tanggal_masuk'); // Tanggal masuk
            $table->datetime('tanggal_keluar')->nullable(); // Tanggal keluar
            $table->enum('status', ['waiting', 'processing', 'completed', 'cancelled'])->default('waiting');
            $table->integer('waktu_estimasi')->nullable(); // Waktu estimasi dalam menit
            $table->integer('priority')->default(0); // Priority untuk algoritma priority scheduler
            $table->boolean('status_denda')->default(false); // Status denda
            $table->decimal('jumlah_denda', 10, 2)->default(0); // Jumlah denda jika ada
            $table->text('keterangan')->nullable(); // Keterangan tambahan
            $table->integer('queue_position')->nullable(); // Posisi dalam antrian
            $table->datetime('waktu_mulai_proses')->nullable(); // Waktu mulai diproses
            $table->datetime('waktu_selesai_proses')->nullable(); // Waktu selesai diproses
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pemilik kontainer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};
