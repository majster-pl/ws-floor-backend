<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('customer_id');
            // $table->unsignedBigInteger('job_type_id')->index();
            $table->boolean('waiting')->nullable()->default(false);
            $table->mediumText('others')->nullable();
            $table->mediumText('description');
            $table->dateTime('dropped_off_at')->nullable();
            $table->dateTime('picked_up_at')->nullable();
            $table->date('booked_date');
            $table->dateTime('booked_date_time');
            $table->integer('allowed_time');
            $table->unsignedBigInteger('created_by');
            $table->char('status', 20);
            $table->timestamps();
            

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('asset_id')->references('id')->on('assets');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
