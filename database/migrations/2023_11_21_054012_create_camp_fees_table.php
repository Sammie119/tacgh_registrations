<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camp_fees', function (Blueprint $table) {
            $table->id()->index();
            $table->integer("camper_type_id")->index();
            $table->string("fee_tag")->comment("description/tag to identify fee");
            $table->double("fee_amount");
            $table->integer("active_flag");
            $table->integer("create_app_user_id");
            $table->integer("update_app_user_id");
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
        Schema::dropIfExists('camp_fees');
    }
}
