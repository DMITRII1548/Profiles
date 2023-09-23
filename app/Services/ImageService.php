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
        string $imagePath,
        int $withd,
        int $height
    ): string {
        $imageInstance = \Intervention\Image\Facades\Image::make($image)
            ->fit($withd, $height);

        Storage::disk('public')->delete('images/' . $imagePath);

        return Storage::disk('public')->putFileAs('/images', $image, $imageName);
    }

    public function update(string $oldImagePath, UploadedFile $image): array
    {
        Storage::disk('public')->delete($oldImagePath);

        return $this->put($image);
    }
}
