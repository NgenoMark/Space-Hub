<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->foreignId('provider_id')->constrained('spaces', 'provider_id');
            $table->foreignId('space_id')->constrained('space', 'space_id');
            $table->string('full_name', 50);
            $table->string('email', 50);
            $table->string('phone_number', 20);
            $table->date('booking_date');
            $table->string('location', 50);
            $table->string('status', 20);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();

            // Add new columns

        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
