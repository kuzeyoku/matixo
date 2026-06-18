<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class MediaService
{
    protected string $disk = 'public';

    /**
     * Görseli yükle, WebP'e dönüştür, opsiyonel boyutları üret.
     *
     * @param array<string, array{int, int}> $sizes  ['thumb' => [320, 240], ...]
     */
    public function upload(UploadedFile $file, string $folder, array $sizes = []): string
    {
        $name = Str::random(40) . '.webp';
        $path = trim($folder, '/') . '/' . $name;

        // Ana görsel — kalite 85
        $main = Image::read($file)->toWebp(85);
        Storage::disk($this->disk)->put($path, (string) $main);

        // Boyutlar
        foreach ($sizes as $key => [$w, $h]) {
            $thumb = Image::read($file)->cover($w, $h)->toWebp(80);
            Storage::disk($this->disk)->put(
                trim($folder, '/') . '/' . $key . '/' . $name,
                (string) $thumb
            );
        }

        return $path;
    }

    /**
     * Görsel ve tüm boyutlarını sil.
     */
    public function delete(?string $path, array $sizes = []): void
    {
        if (empty($path)) return;

        $disk = Storage::disk($this->disk);
        $disk->delete($path);

        $folder = dirname($path);
        $name   = basename($path);
        foreach (array_keys($sizes) as $sizeKey) {
            $disk->delete($folder . '/' . $sizeKey . '/' . $name);
        }
    }

    /**
     * Bir alana yüklenen dosya varsa uygula, yoksa eskiyi geri döndür.
     */
    public function handle(?UploadedFile $file, ?string $existingPath, string $folder, array $sizes = []): ?string
    {
        if ($file && $file->isValid()) {
            $this->delete($existingPath, $sizes);
            return $this->upload($file, $folder, $sizes);
        }
        return $existingPath;
    }

    public function url(?string $path): ?string
    {
        return $path ? Storage::disk($this->disk)->url($path) : null;
    }
}
