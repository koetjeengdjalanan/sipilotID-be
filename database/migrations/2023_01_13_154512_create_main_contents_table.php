<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_contents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->smallInteger('section');
            $table->string('title');
            $table->json('content')->nullable();
            $table->string('image')->nullable();
            $table->foreignUuid('user_id')->constrained();
            $table->softDeletes();
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
        Schema::dropIfExists('main_contents');
    }
};
