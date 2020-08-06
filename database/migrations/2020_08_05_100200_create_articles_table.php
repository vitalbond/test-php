<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('text');
            $table->string('source_id', 50);
            $table->string('source_url', 200);
            $table->dateTime('datetime');
            $table->unsignedTinyInteger('has_image')->default(0);

            $table->timestamps();

            $table->unique(['source_id']);
            $table->index(['datetime']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
