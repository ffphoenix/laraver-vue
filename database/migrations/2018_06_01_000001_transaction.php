<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->bigInteger('amount')->default(0);
            $table->enum('status', ['succeeded', 'failed'])->default('failed');
            $table->integer('currency_id')->unsigned()->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->index('status');
            $table->index('created_at');
            $table->charset = 'utf8mb4';
            $table->engine = 'InnoDB';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
