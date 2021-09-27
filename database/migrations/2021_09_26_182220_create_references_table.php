<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('designation')->nullable();
            $table->string('worked_from')->nullable();
            $table->string('address')->nullable();
            $table->string('company_name')->nullable();
            $table->string('worked_to')->nullable();
            $table->tinyInteger('would_rehire')->nullable();
            $table->string('work_quality')->nullable();
            $table->tinyInteger('can_handle_stress')->nullable();
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
        Schema::dropIfExists('references');
    }
}
