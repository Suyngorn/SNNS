<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_rooms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('book_id')->unsigned();
            $table->bigInteger('room_id')->unsigned();
            $table->timestamps();
            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('room_id')->references('id')->on('libraries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books_rooms');
    }
}
