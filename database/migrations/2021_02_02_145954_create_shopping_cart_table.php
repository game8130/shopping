<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingCartTable extends Migration
{
    private $table = 'shopping_cart';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id')->comment('PK');
            $table->unsignedInteger('user_id')->index()->comment('使用者 users>id');
            $table->string('product_uuid', 36)->comment('產品 uuid');
            $table->unsignedSmallInteger('number')->comment('數量');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '購物車'");
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
