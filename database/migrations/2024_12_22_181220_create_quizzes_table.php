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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            // 地域との関連付け
            $table->foreignId('region_id')
                  ->constrained()
                  ->onDelete('cascade');

            // カテゴリーとの関連付け
            $table->foreignId('category_id')
                  ->references('id')
                  ->on('quiz_categories')
                  ->onDelete('cascade');

            // クイズの問題文
            $table->text('question');

            // クイズの解説文
            $table->text('explanation');

            // AIによって生成された問題かどうかを示すフラグ
            // 将来的なAI生成問題の品質管理や分析に使用
            $table->boolean('is_ai_generated')
                  ->default(false)
                  ->comment('AIによって生成された問題かどうかを示すフラグ');
            $table->timestamps();
            // 地域とカテゴリーの組み合わせによる検索するためのインデックス
            $table->index(['region_id', 'category_id'], 'quiz_region_category_index');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
