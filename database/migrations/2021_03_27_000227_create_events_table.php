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
            $table->float('order')->nullable();
            $table->float('odometer_in')->nullable();
            $table->float('odometer_out')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->boolean('waiting')->nullable()->default(false);
            $table->mediumText('others')->nullable();
            $table->mediumText('description');
            $table->mediumText('special_instructions')->nullable();
            $table->mediumText('free_text')->nullable();
            $table->dateTime('arrived_date')->nullable();
            $table->dateTime('collected_at')->nullable();
            $table->dateTime('booked_date_time');
            $table->float('allowed_time', 8, 2);
            $table->float('spent_time', 8, 2)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->char('status', 40);
            $table->timestamps();
            $table->softDeletes();


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
