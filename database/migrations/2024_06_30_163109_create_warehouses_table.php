<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id('warehouse_id');
            $table->string('warehouse_name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->foreignId('deal_id')->nullable()->constrained('deals','deal_id');
            $table->foreignId('provider_id')->constrained('users','id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
