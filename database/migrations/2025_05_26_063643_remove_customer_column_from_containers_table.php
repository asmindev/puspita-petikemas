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
            // Remove the old customer text column since we now use customer_id foreign key
            $table->dropColumn('customer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('containers', function (Blueprint $table) {
            // Add back the customer column if needed (though this shouldn't be used)
            $table->string('customer')->nullable()->after('container_number');
        });
    }
};
