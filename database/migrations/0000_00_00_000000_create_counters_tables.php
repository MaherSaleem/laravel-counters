<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $countersTable = config('counter.counter.table_name');
        $counterableTableName = config('counter.counterable.table_name');
        Schema::create($countersTable, function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
            $table->string('name');
            $table->double('initial_value')->default('0');
            $table->double('value')->default('0');
            $table->double('step')->default('1');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create($counterableTableName, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('counterable_id');
            $table->string('counterable_type');
            $table->unsignedInteger('counter_id');
            $table->double('value')->default('0');
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
        $countersTable = config('counter.counter.table_name');
        $counterableTableName = config('counter.counterable.table_name');

        Schema::dropIfExists($countersTable);
        Schema::dropIfExists($counterableTableName);
    }
}
