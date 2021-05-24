<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitPromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produit_promotion', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('promotion_id')->unsigned();
            $table->bigInteger('produit_id')->unsigned()->nullable();
            $table->bigInteger('categorie_id');
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
        Schema::dropIfExists('produit_promotion');
    }
}
