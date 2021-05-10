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
            $table->bigInteger('promotion_id')->unsigned()->nullable();
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('produit_id')->unsigned()->nullable();
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade')->onUpdate('cascade');
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
