<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->string('group_name');
            $table->string('group_destination');
            $table->string('destination_lat');
            $table->string('destination_long');
            $table->string('group_image_url');
            $table->string('group_status');
            $table->string('creator_id');
            $table->date('date')->format('d/m/Y');
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
        Schema::dropIfExists('groups');
    }
}
