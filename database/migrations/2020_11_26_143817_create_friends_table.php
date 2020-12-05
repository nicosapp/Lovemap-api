<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('friends', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('first_user_id')->length(20)->unsigned()->index();
      $table->bigInteger('second_user_id')->length(20)->unsigned()->index();
      $table->timestamps();

      $table->foreign('first_user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('second_user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('friends');
  }
}
