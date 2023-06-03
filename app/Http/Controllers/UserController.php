<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\User\MinifiedUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update(UpdateRequest $request): array
    {
        $data = $request->validated();

        Auth::user()
            ->update([
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
            ]);

        return MinifiedUserResource::make(Auth::user())->resolve();
    }
}
