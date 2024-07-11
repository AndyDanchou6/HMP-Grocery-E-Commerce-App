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
        Schema::table('selected_items', function (Blueprint $table) {
            $table->string('payment_proof')->nullable()->after('proof_of_delivery');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selected_items', function (Blueprint $table) {
            $table->dropColumn('payment_proof');
        });
    }
};
