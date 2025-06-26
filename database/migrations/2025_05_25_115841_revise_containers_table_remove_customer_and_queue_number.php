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
            // Drop queue_number column if it exists
            if (Schema::hasColumn('containers', 'queue_number')) {
                $table->dropColumn('queue_number');
            }

            // Drop customer column if it exists
            if (Schema::hasColumn('containers', 'customer')) {
                $table->dropColumn('customer');
            }

            // Modify priority column to be enum instead of integer
            $table->enum('priority', ['Normal', 'Tinggi', 'Darurat'])->default('Normal')->change();

            // Modify jpt column description comment
            $table->enum('jpt', ['Export', 'Import', 'Transshipment', 'Domestic'])
                ->comment('Jasa Pengguna Transportasi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('containers', function (Blueprint $table) {
            // Add back queue_number column
            $table->integer('queue_number')->nullable()->after('container_number');

            // Add back customer column
            $table->string('customer')->nullable()->after('user_id');

            // Revert priority back to integer
            $table->integer('priority')->default(1)->change();

            // Revert jpt comment
            $table->enum('jpt', ['Export', 'Import', 'Transshipment', 'Domestic'])
                ->comment('Jenis Layanan Transportasi')->change();
        });
    }
};
