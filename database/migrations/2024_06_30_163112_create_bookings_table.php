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
            $table->foreignId('user_id')->constrained('users','id');
            $table->foreignId('space_id')->constrained('spaces','space_id');
            $table->date('booking_date');
            $table->string('location', 50);
            $table->string('status', 20);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
            $table->string('space_name')->nullable()->after('space_name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
