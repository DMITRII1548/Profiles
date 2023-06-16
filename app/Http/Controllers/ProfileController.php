<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\StoreRequest;
use App\Http\Resources\Profile\ProfileResource;
use App\Models\Profile;
use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    private ImageService $imageService;

    public function __construct()
    {
        $this->imageService = new ImageService;
    }

    public function showProfileOfCurrentUser(): array|Response
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return response([], 204);
        } else {
            return ProfileResource::make($profile)->resolve();
        }
    }

    public function show(Profile $profile): array
    {
        return ProfileResource::make($profile)->resolve();
    }

    public function store(StoreRequest $request): Response
    {
        $data = $request->validated();

        // storing file
        $image = $this->imageService->put($data['image']);

        // fit image
        $this->imageService->fit($data['image'], $image['name'], 224, 224);

        // create profile
        Auth::user()
            ->profile()
            ->create([
                'title' => $data['title'],
                'description' => $data['description'],
                'avatar_path' => $image['path'],
                'avatar_url' => $image['url'],
            ]);

        return response(['created' => true]);
    }

    public function destroy(): Response
    {
        $profile = Auth::user()->profile;

        Storage::disk('public')->delete($profile->avatar_path);
        $profile->delete();

        return response([
            'deleted' => true,
        ]);
    }
}
