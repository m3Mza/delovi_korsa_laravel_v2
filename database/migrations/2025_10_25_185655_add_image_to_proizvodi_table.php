<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('proizvodi', function (Blueprint $table) {
        $table->string('image')->nullable(); // store image path
    });
}

public function down()
{
    Schema::table('proizvodi', function (Blueprint $table) {
        $table->dropColumn('image');
    });
}

};
