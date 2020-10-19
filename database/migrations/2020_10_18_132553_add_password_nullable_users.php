<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordNullableUsers extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('password');
    });
    Schema::table('users', function (Blueprint $table) {
      $table->string('password')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->string('password');
    });
  }
}
