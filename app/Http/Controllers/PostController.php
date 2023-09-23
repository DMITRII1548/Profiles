<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private ImageService $imageService;

    public function __construct()
    {
        $this->imageService = new ImageService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): Response
    {
        $data = $request->validated();

        if (!isset(Auth::user()->profile)) {
            response(['message' => 'profile does not exist'], 500);
        }

        $image = $this->imageService->put($data['image']);
        $image['path'] = $this->imageService->fit(
            $data['image'],
            $image['name'],
            $image['path'],
            224,
            224
        );

        $post = Auth::user()->profile->posts()->create([
            'title' => $data['title'],
            'content' => $data['content'],
            'image_path' => $image['path'],
            'image_url' => $image['url']
        ]);

        $post->tags()->attach($data['tags_id']);

        return response([
            'created' => true,
            'post_id' => $post->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
