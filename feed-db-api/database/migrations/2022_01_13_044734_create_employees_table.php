<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('series_reference', 25);
            $table->date('period')->nullable();
            $table->integer('data_value')->nullable();
            $table->enum('suppress', ['Y', 'N'])->nullable();
            $table->char('status')->nullable();
            $table->string('unit', 50)->nullable();
            $table->tinyInteger('magnitude');
            $table->string('subject', 1000)->nullable();
            $table->string('group', 255)->nullable();
            $table->json('series_title')->nullable();
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
        Schema::dropIfExists('employee');
    }
}
