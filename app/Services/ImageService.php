<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function put(UploadedFile $image): array
    {
        $imageName = random_int(10000, 99999) . md5(Carbon::now() . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        $imagePath = Storage::disk('public')->putFileAs('/images', $image, $imageName);
        $imageUrl = url('/storage/' . $imagePath);

        return [
            'name' => $imageName,
            'path' => $imagePath,
            'url' => $imageUrl,
        ];
    }

    public function fit(
        UploadedFile $image,
        string $imageName,
        int $withd,
        int $height
    ): void {
        \Intervention\Image\Facades\Image::make($image)->fit($withd, $height)
            ->save(storage_path('app/public/images/' . $imageName));
    }
}
