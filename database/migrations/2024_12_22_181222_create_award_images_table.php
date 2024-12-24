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
        Schema::create('award_images', function (Blueprint $table) {
            $table->id();

            // 地域との関連付け
            $table->foreignId('region_id')
                  ->constrained()
                  ->onDelete('cascade')
                  ->comment('表彰状が関連する地域のID');

            // カテゴリーとの関連付け
            $table->foreignId('category_id')
                  ->references('id')
                  ->on('quiz_categories')
                  ->onDelete('cascade')
                  ->comment('表彰状が関連するカテゴリーのID');

            // 画像ファイルのパス
            $table->string('image_path')
                  ->comment('表彰状画像ファイルのストレージパス');
            $table->timestamps();
            // 地域とカテゴリーの組み合わせは一意であることを保証
            $table->unique(['region_id', 'category_id'], 'unique_region_category_award');

            // 地域とカテゴリーの組み合わせによる検索を最適化するための複合インデックス
            $table->index(['region_id', 'category_id'], 'award_region_category_index');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('award_images');
    }
};
