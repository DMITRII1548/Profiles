<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\StoreRequest;
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

    public function store(StoreRequest $request): Response
    {
        $data = $request->validated();

        // storing file
        $image = $this->imageService->put($data['image']);

        // fit image
        $this->imageService->fit($data['image'], $image['name'], 200, 200);

        // create profile
        Auth::user()
            ->profile()
            ->create([
                'title' => $data['title'],
                'description' => $data['description'],
                'avatar_path' => $image['path'],
                'avatar_url' => $image['url'],
            ]);

        return response([ 'created' => true ]);
    }
}
