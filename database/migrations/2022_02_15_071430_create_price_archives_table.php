<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_archives', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('region_id');
            $table->bigInteger('purchase')->default(0);
            $table->bigInteger('selling')->default(0);
            $table->bigInteger('discount')->default(0);
            $table->timestamps();

            $table->index(['product_id', 'region_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_archives');
    }
}
