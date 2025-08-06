<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftReceivePaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_receive_paids', function (Blueprint $table) {
            $table->id();
            $table->integer('_account_type_id');
            $table->integer('_account_group_id');
            $table->integer('_ledger_id');
            $table->string('_type',10)->nullable();
            $table->integer('organization_id')->nullable();
            $table->integer('_branch_id')->nullable();
            $table->integer('_cost_center_id')->nullable();
            $table->integer('_budget_id')->nullable();
            $table->string('_short_narr')->nullable();
            $table->text('_gift_detail')->nullable();
            $table->string('_gift_type')->nullable()->comment('Receive,Paid');
            $table->double('_dr_amount',15,4)->default(0);
            $table->double('_cr_amount',15,4)->default(0);
            $table->integer('_user_id')->nullable();
            $table->string('_user_name')->nullable();
            $table->tinyInteger('_status')->default(0);
            $table->tinyInteger('_lock')->default(0);
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
        Schema::dropIfExists('gift_receive_paids');
    }
}
