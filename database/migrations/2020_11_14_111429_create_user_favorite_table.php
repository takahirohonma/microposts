<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFavoriteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_favorites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('micropost_id');
            $table->timestamps();
            
            
            //外部キー制約
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('micropost_id')->references('id')->on('microposts')->onDlete('cascade');
        
        //user_idとmicroposts_idの重複防止措置
        $table->unique(['user_id', 'micropost_id']);
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_favorites');
    }
}
