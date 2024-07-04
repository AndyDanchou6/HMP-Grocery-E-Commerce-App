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
        Schema::create('selected_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('referenceNo');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('user_id');
            $table->string('status')->nullable()->default('forPackage');
            $table->string('order_retrieval')->nullable();
            $table->integer('quantity')->default(1);
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('fb_link')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_condition')->nullable();
            $table->string('proof_of_delivery')->nullable();
            $table->datetime('delivery_date')->nullable();
            $table->timestamps();

            $table->foreign('courier_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('inventories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selected_items');
    }
};
