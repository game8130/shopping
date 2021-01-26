<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategory3Table extends Migration
{
    private $table = 'category3';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->smallIncrements('id')->comment('PK');
            $table->unsignedSmallInteger('category2_id')->comment('類別階層2 category2>id');
            $table->unsignedSmallInteger('category3_name_id')->comment('類別階層3名稱 category3_name>id');
            $table->string('uuid', 36)->unique()->comment('uuid');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '類別階層3'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
