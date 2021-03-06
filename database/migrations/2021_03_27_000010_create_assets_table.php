<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('reg');
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->unsignedBigInteger('belongs_to')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->char('status', 20);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['reg', 'owner_id']);

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('owner_id')->references('id')->on('companies');
            $table->foreign('belongs_to')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
