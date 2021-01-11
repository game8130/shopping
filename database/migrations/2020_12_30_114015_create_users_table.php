<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    private $table = 'users';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 36)->unique()->comment('uuid');
            $table->unsignedSmallInteger('level_id')->comment('消費等級 level>id');
            $table->string('account', 20)->unique()->comment('帳號');
            $table->string('email')->unique()->comment('Email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 30)->unique()->comment('電話');
            $table->string('password', 60)->comment('密碼');
            $table->string('name', 30)->comment('暱稱');
            $table->longText('token')->comment('登入Token');
            $table->unsignedTinyInteger('active')->default(1)->comment('狀態(1:啟用,2:停用,3:刪除)');
            $table->dateTime('login_at')->nullable()->comment('最後登入時間');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `".$this->table."` COMMENT '使用者資訊'");
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
