<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingSpacesTable extends Migration
{
    public function up()
    {
        Schema::create('booking_spaces', function (Blueprint $table) {
            $table->foreignId('booking_id')->constrained('bookings','booking_id');
            $table->foreignId('space_id')->constrained('spaces','space_id');
            $table->primary(['booking_id', 'space_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_spaces');
    }
}
