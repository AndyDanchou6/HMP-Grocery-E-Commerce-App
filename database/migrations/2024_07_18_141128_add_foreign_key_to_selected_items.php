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
            $table->unsignedBigInteger('service_fee_id')->nullable();

            $table->foreign('service_fee_id')
                  ->references('id')->on('service_fee')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selected_items', function (Blueprint $table) {
             $table->dropForeign(['service_fee_id']);

             $table->dropColumn('service_fee_id');
        });
    }
};
