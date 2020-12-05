<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
           // $table->bigIncrements('id');
            $table->id(); // LARAVEL 7 o superior
            $table->string('title',500)->nullable();
            $table->string('url_clean',500)->nullable();
            $table->text('content')->nullable();
            $table->enum('posted', ['yes', 'not'])->default('not');
           // $table->bigInteger('category_id')->unsigned()->nullable();
            $table->timestamps();
           /* $table->foreignId('category_id') // LARAVEL 7 o superior
            ->references('id')
            ->on('categories')
            ->onDelete('cascade');*/

            $table->foreignId('category_id')->constrained()
            ->onDelete('cascade');

            /*$table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('cascade');*/

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
