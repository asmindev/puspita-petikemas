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
        Schema::table('containers', function (Blueprint $table) {
            // Hapus kolom queue_number
            $table->dropColumn('queue_number');

            // Hapus kolom customer (jika ada)
            if (Schema::hasColumn('containers', 'customer')) {
                $table->dropColumn('customer');
            }

            // Ubah kolom priority dari integer ke enum
            $table->dropColumn('priority');
            $table->enum('priority', ['Normal', 'Tinggi', 'Darurat'])->default('Normal')->after('jpt');

            // Update keterangan JPT (kolom jpt tetap sama, hanya semantiknya yang berubah)
            // JPT sekarang adalah "Jasa Pengguna Transportasi" bukan "Jenis Layanan Transportasi"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('containers', function (Blueprint $table) {
            // Kembalikan queue_number
            $table->string('queue_number')->nullable()->after('container_number');

            // Kembalikan customer (jika diperlukan)
            $table->string('customer')->nullable()->after('user_id');

            // Kembalikan priority ke integer
            $table->dropColumn('priority');
            $table->integer('priority')->default(1)->after('jpt');
        });
    }
};
