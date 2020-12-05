<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('locations', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('user_id')->length(20)->unsigned()->index();
      $table->string('title');
      $table->float('lat', 25, 20);
      $table->float('lng', 25, 20);
      $table->text('comment')->nullable();
      $table->string('partner')->nullable();
      $table->date('date')->nullable();
      $table->time('time')->nullable();
      $table->integer('duration')->nullable();
      $table->integer('rating')->nullable();
      $table->string('country')->nullable();
      $table->string('city')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('locations');
  }
}
