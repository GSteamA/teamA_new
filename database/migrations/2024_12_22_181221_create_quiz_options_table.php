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
        Schema::create('quiz_options', function (Blueprint $table) {
            $table->id();


            // クイズとの関連付け
            $table->foreignId('quiz_id')
                  ->constrained()
                  ->onDelete('cascade')
                  ->comment('このオプションが属するクイズのID');

            // 選択肢のテキスト
            $table->text('option_text')
                  ->comment('選択肢として表示されるテキスト');

            // 正解フラグ
            $table->boolean('is_correct')
                  ->default(false)
                  ->comment('この選択肢が正解かどうかを示すフラグ');

            // 表示順序
            $table->integer('display_order')
                  ->comment('選択肢の表示順序（1から始まる連番）');
            $table->timestamps();
            // クイズIDと表示順序による複合インデックス
            $table->index(['quiz_id', 'display_order']);

            // クイズIDごとに正解フラグがtrueの選択肢が1つだけになるよう制約
            // $table->unique(['quiz_id', 'is_correct'], 'quiz_correct_answer_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_options');
    }
};
