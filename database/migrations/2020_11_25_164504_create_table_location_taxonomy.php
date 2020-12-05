<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLocationTaxonomy extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('location_taxonomy', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('taxonomy_id')->unsigned()->index();
      $table->bigInteger('location_id')->unsigned()->index();
      $table->timestamps();

      $table->foreign('taxonomy_id')->references('id')->on('taxonomies')->onDelete('cascade');
      $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('location_taxonomy');
  }
}
