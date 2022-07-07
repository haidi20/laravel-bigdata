<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignFinanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_finances', function (Blueprint $table) {
            $table->id();
            $table->string('CMTE_ID')->nullable();
            $table->string('AMNDT_IND')->nullable();
            $table->string('RPT_TP')->nullable();
            $table->string('TRANSACTION_PGI')->nullable();
            $table->integer('IMAGE_NUM')->nullable();
            $table->string('TRANSACTION_TP')->nullable();
            $table->string('ENTITY_TP')->nullable();
            $table->string('NAME')->nullable();
            $table->string('CITY')->nullable();
            $table->string('STATE')->nullable();
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
        Schema::drop('campaign_finances', function (Blueprint $table) {
            Schema::dropIfExists('campaign_finances');
        });
    }
}
