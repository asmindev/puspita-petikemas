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
            $table->string('container_number'); // Removed unique constraint to allow re-entry
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('priority', ['Normal', 'High'])->default('Normal');
            $table->timestamp('entry_date')->nullable();
            $table->timestamp('exit_date')->nullable();
            $table->boolean('penalty_status')->default(false);
            $table->decimal('penalty_amount', 10, 2)->default(0);
            $table->text('penalty_notes')->nullable();
            $table->timestamp('process_start_time')->nullable();
            $table->timestamp('process_end_time')->nullable();
            $table->text('notes')->nullable();
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
