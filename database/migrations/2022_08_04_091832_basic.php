<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Basic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        Schema::create('model', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('name')->unique();

            $table->foreign('brand_id')
                ->references('id')
                ->on('brand')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::create('car', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('model_id')->nullable();

            $table->integer('engine_type');
            $table->integer('main_axe');

            $table->foreign('model_id')
                ->references('id')
                ->on('model')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('car');
        Schema::drop('model');
        Schema::drop('brand');
    }
}
