<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            // システム内部での処理に使用する地域名
            // 例：'tokyo_harajuku'
            $table->string('name');

            // ユーザーに表示する地域名
            // 例：'東京（原宿）'
            $table->string('display_name');

            // URLパラメータなどで使用する一意の地域コード
            // 例：'harajuku'
            $table->string('code')->unique();
            $table->timestamps();

            // クイズメニューでの地域検索時に使用
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
