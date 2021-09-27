<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualityIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_indicators', function (Blueprint $table) {
            $table->id();
            $table->integer('region_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('array_id')->nullable();
            $table->integer('farmer_contour_id')->nullable();
            $table->year('year')->nullable();
            $table->float('quality_indicator')->nullable();
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
        Schema::dropIfExists('quality_indicators');
    }
}
