<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class AwardImage extends Model
{
    protected $fillable = [
        'region_id',
        'category_id',
        'image_path',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(QuizCategory::class, 'category_id');
    }


    /**
     * 指定された地域とカテゴリーの組み合わせに対応する表彰状画像を取得します。
     * 
     * @param int $regionId 地域ID
     * @param int $categoryId カテゴリーID
     * @return AwardImage|null
     */
    public static function findAwardImage(int $regionId, int $categoryId): ?AwardImage
    {
        return static::where([
            'region_id' => $regionId,
            'category_id' => $categoryId
        ])->first();
    }

    /**
     * 表彰状画像のパブリックURL（アクセス可能なURL）を取得します。
     * 
     * @return string|null 画像のURL、存在しない場合はnull
     */
    public function getPublicUrl(): ?string
    {
        if (Storage::disk('public')->exists($this->image_path)) {
            return Storage::url($this->image_path);
        }
        return null;
    }

    /**
     * 表彰状画像を保存します。既存の画像がある場合は置き換えられます。
     * 
     * @param int $regionId 地域ID
     * @param int $categoryId カテゴリーID
     * @param \Illuminate\Http\UploadedFile $file アップロードされた画像ファイル
     * @return AwardImage 保存された表彰状画像モデル
     */
    public static function storeAwardImage(
        int $regionId,
        int $categoryId,
        \Illuminate\Http\UploadedFile $file
    ): AwardImage {
        // ファイル名を生成（地域ID_カテゴリーID_タイムスタンプ.拡張子）
        $fileName = sprintf(
            'award_%d_%d_%s.%s',
            $regionId,
            $categoryId,
            now()->format('YmdHis'),
            $file->extension()
        );

        // 既存の画像を検索
        $existingAward = static::findAwardImage($regionId, $categoryId);

        // トランザクション開始
        return \DB::transaction(function () use ($regionId, $categoryId, $file, $fileName, $existingAward) {
            // 既存の画像ファイルが存在する場合は削除
            if ($existingAward) {
                if (Storage::disk('public')->exists($existingAward->image_path)) {
                    Storage::disk('public')->delete($existingAward->image_path);
                }
            }

            // 新しい画像を保存
            $path = $file->storeAs('awards', $fileName, 'public');

            // レコードを更新または作成
            if ($existingAward) {
                $existingAward->update(['image_path' => $path]);
                return $existingAward->fresh();
            }

            return static::create([
                'region_id' => $regionId,
                'category_id' => $categoryId,
                'image_path' => $path
            ]);
        });
    }

    /**
     * モデルが削除される前に実行されるイベント。
     * 関連する画像ファイルも削除します。
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($awardImage) {
            if (Storage::disk('public')->exists($awardImage->image_path)) {
                Storage::disk('public')->delete($awardImage->image_path);
            }
        });
    }

}
