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
        Schema::create('quiz_categories', function (Blueprint $table) {
            $table->id();

            // システム内部での処理に使用するカテゴリー名
            // 例：'culture', 'history'
            $table->string('name');

            // ユーザーに表示するカテゴリー名
            // 例：'文化', '歴史'
            $table->string('display_name');

            // URLパラメータやシステム内部での識別に使用する一意のコード
            // 例：'culture-quiz', 'history-quiz'
            $table->string('code')->unique();
            $table->timestamps();
            
            // カテゴリーコードでの検索を最適化するためのインデックス
            // クイズ選択時のカテゴリーフィルタリングで使用されます
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_categories');
    }
};
