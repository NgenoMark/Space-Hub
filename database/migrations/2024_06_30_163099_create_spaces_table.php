<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpacesTable extends Migration
{
    public function up()
    {
        Schema::create('spaces', function (Blueprint $table) {
            $table->id('space_id');
            $table->string('space_name', 100);
            $table->string('space_type', 50);
            $table->string('location', 50);
            $table->decimal('capacity', 10, 2);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->foreignId('deal_id')->nullable()->constrained('deals','deal_id');
            $table->foreignId('provider_id')->constrained('users','id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spaces');
    }
}

