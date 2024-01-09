<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_property_values', function (Blueprint $table) {
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreignId('property_value_id')->references('id')->on('property_values')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_property_values');
    }
}
