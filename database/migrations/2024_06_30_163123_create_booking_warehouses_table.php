<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingWarehousesTable extends Migration
{
    public function up()
    {
        Schema::create('booking_warehouses', function (Blueprint $table) {
            $table->foreignId('booking_id')->constrained('bookings','booking_id');
            $table->foreignId('warehouse_id')->constrained('warehouses','warehouse_id');
            $table->primary(['booking_id', 'warehouse_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_warehouses');
    }
}
