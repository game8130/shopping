<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    private $table = 'product';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->Increments('id')->comment('PK');
            $table->string('uuid', 36)->unique()->comment('uuid');
            // $table->unsignedSmallInteger('category1_id')->comment('類別階層1 category1>id');
            // $table->unsignedSmallInteger('category2_id')->comment('類別階層2 category2>id');
            $table->unsignedSmallInteger('category3_id')->comment('類別階層3 category3>id');
            $table->text('image')->nullable()->comment('商品縮圖');
            $table->string('name', 60)->comment('商品名稱');
            $table->text('description')->comment('商品說明');
            $table->unsignedInteger('suggested_price')->comment('建議售價');
            $table->unsignedInteger('price')->comment('售價');
            $table->unsignedSmallInteger('residual')->default(0)->comment('目前剩餘數量');
            $table->unsignedTinyInteger('active')->default(1)->comment('狀態(1:啟用,2:停用,3:刪除)');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `" . $this->table . "` COMMENT '產品'");
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
