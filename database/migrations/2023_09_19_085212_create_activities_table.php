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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->longText('name');
            $table->date('first_due_date');
            $table->date('second_due_date');
            $table->string('status')->default('pending')->comment('pending, completed, in_progress');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('cron_expression')->nullable();
            $table->longText('cron_string')->nullable();
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
        Schema::dropIfExists('activities');
    }
};
