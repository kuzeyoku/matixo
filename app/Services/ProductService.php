<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductFeature;
use App\Models\ProductSpec;
use Illuminate\Database\Eloquent\Model;

class ProductService extends BaseService
{
    protected string $modelClass = Product::class;
    protected array $searchable = ['title', 'code', 'slug', 'short_description'];

    protected function beforeSave(array $data): array
    {
        $media = app(MediaService::class);

        // Güncelleme sırasında yeni dosya yüklenmemişse mevcut resmi koru
        $existingCover = $data['cover_image'] ?? null;
        $existingOg    = $data['og_image'] ?? null;

        // Eğer validated() array'inde key yoksa (dosya alanı boş geldiyse),
        // veritabanındaki mevcut değeri oku
        $productId = request()->route('product') ?? request()->route('id');
        if ($productId) {
            $existing = Product::find($productId);
            if ($existing) {
                if ($existingCover === null && !request()->hasFile('cover_image')) {
                    $existingCover = $existing->cover_image;
                }
                if ($existingOg === null && !request()->hasFile('og_image')) {
                    $existingOg = $existing->og_image;
                }
            }
        }

        $data['cover_image'] = $media->handle(
            request()->file('cover_image'),
            $existingCover,
            config('matixo.media.product_cover_path'),
            config('matixo.media.sizes')
        );

        $data['og_image'] = $media->handle(
            request()->file('og_image'),
            $existingOg,
            config('matixo.media.product_cover_path')
        );

        if (request()->boolean('cover_image_remove')) {
            $media->delete($data['cover_image'] ?? null, config('matixo.media.sizes'));
            $data['cover_image'] = null;
        }

        // Repeater alanları ana fillable'a karışmasın
        unset($data['features'], $data['specs'], $data['gallery_alt'], $data['gallery_files']);

        return $data;
    }

    protected function afterCreate(Model $model, array $data): void
    {
        $this->syncFeatures($model, $data['features'] ?? []);
        $this->syncSpecs($model, $data['specs'] ?? []);
        $this->syncGallery($model);
    }

    protected function afterUpdate(Model $model, array $data): void
    {
        $this->syncFeatures($model, $data['features'] ?? []);
        $this->syncSpecs($model, $data['specs'] ?? []);
        $this->syncGallery($model);
    }

    protected function beforeDelete(Model $model): void
    {
        $media = app(MediaService::class);
        $media->delete($model->cover_image, config('matixo.media.sizes'));
        $media->delete($model->og_image);
        foreach ($model->images as $img) {
            $media->delete($img->image_path);
        }
    }

    protected function syncFeatures(Product $product, array $features): void
    {
        $product->features()->delete();
        foreach ($features as $i => $f) {
            if (empty($f['feature_text'])) continue;
            $product->features()->create([
                'feature_text' => $f['feature_text'],
                'sort_order'   => $i,
            ]);
        }
    }

    protected function syncSpecs(Product $product, array $specs): void
    {
        $product->specs()->delete();
        foreach ($specs as $i => $s) {
            if (empty($s['spec_key']) && empty($s['spec_value'])) continue;
            $product->specs()->create([
                'spec_key'   => $s['spec_key']   ?? [],
                'spec_value' => $s['spec_value'] ?? [],
                'sort_order' => $i,
            ]);
        }
    }

    protected function syncGallery(Product $product): void
    {
        $media   = app(MediaService::class);
        $request = request();

        // Silinmesi istenen mevcut görseller
        $removeIds = (array) $request->input('gallery_remove', []);
        if ($removeIds) {
            foreach ($product->images()->whereIn('id', $removeIds)->get() as $img) {
                $media->delete($img->image_path);
                $img->delete();
            }
        }

        // Mevcut görsellerin alt text + sıralama güncellemesi
        foreach ((array) $request->input('gallery_existing', []) as $i => $row) {
            if (empty($row['id'])) continue;
            ProductImage::where('id', $row['id'])->update([
                'alt_text'   => $row['alt_text'] ?? null,
                'sort_order' => $i,
            ]);
        }

        // Yeni yüklenen görseller
        if ($request->hasFile('gallery_files')) {
            $altTexts = (array) $request->input('gallery_alt', []);
            $startOrder = (int) $product->images()->max('sort_order') + 1;
            foreach ($request->file('gallery_files') as $j => $file) {
                if (!$file || !$file->isValid()) continue;
                $path = $media->upload($file, config('matixo.media.product_gallery_path'), config('matixo.media.sizes'));
                $product->images()->create([
                    'image_path' => $path,
                    'alt_text'   => $altTexts[$j] ?? null,
                    'sort_order' => $startOrder + $j,
                ]);
            }
        }
    }
}
