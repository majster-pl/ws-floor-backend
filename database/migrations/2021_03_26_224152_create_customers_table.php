<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->unique();
            $table->string('email')->unique();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('created_by');
            $table->mediumText('customer_contact')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->unsignedBigInteger('owner_id');

            $table->foreign('owner_id')->references('id')->on('companies');
            $table->foreign('created_by')->references('id')->on('users');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
