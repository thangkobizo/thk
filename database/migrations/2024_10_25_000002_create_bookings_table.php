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
        Schema::create('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id')->autoIncrement()->comment('Primary key for bookings');
            $table->unsignedBigInteger('hotel_id')->comment('Foreign key referencing hotels');
            $table->string('customer_name', 255)->comment('Customer name');
            $table->string('customer_contact', 255)->comment('Customer contact information');
            $table->timestamp('checkin_time')->comment('Check-in timestamp');
            $table->timestamp('checkout_time')->comment('Check-out timestamp');
            $table->timestamps();
            $table->foreign('hotel_id')
                ->references('hotel_id')
                ->on('hotels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
