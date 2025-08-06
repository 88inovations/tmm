<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('_account_group_id');
            $table->foreign('_account_group_id')->references('id')->on('account_groups');
            $table->integer('_account_head_id')->nullable();
            $table->string('_name')->nullable();
            $table->string('_alious')->nullable();
            $table->string('_code',50)->nullable();
            $table->string('_image',250)->nullable();
            $table->string('_nid',250)->nullable();
            $table->longText('_other_document')->nullable();
            $table->string('_email',60)->nullable();
            $table->string('_phone',60)->nullable();
            $table->string('_address',200)->nullable();
            $table->string('_note',200)->nullable();
            $table->double('_credit_limit',15,4)->default(0);
            $table->integer('_branch_id')->nullable();
            $table->integer('_is_user')->default(0);
            $table->integer('_user_id')->nullable();
            $table->integer('_is_sales_form')->default(0);
            $table->integer('_is_purchase_form')->default(0);
            $table->integer('_is_all_branch')->default(0);
            $table->integer('_short')->default(0);
            $table->integer('_show')->default(0);
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_is_used')->default(0);
            $table->string('_created_by',60)->nullable();
            $table->string('_updated_by',60)->nullable();
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
        Schema::dropIfExists('account_ledgers');
    }
}
