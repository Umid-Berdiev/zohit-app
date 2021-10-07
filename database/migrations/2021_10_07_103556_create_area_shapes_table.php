<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaShapesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_shapes', function (Blueprint $table) {
            $table->id();
            $table->integer('contour_number')->nullable();
            $table->string('shape_leng')->nullable();
            $table->string('shape_area')->nullable();
            $table->multiPolygon('geometry', 'GEOGRAPHY', 4326)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_shapes');
    }
}
