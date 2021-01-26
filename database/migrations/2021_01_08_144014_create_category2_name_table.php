<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategory2NameTable extends Migration
{
    private $table = 'category2_name';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->smallIncrements('id')->comment('PK');
            $table->string('category2_name', 30)->unique()->comment('名稱');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '類別階層2名稱'");
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
