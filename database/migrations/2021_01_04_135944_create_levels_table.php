<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelsTable extends Migration
{
    private $table = 'levels';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->smallIncrements('id')->comment('PK');
            $table->string('name', 20)->unique()->comment('名稱');
            $table->unsignedInteger('amount')->comment('最少消費金額');
            $table->unsignedInteger('amount_max')->comment('最多消費金額');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '消費等級'");
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
