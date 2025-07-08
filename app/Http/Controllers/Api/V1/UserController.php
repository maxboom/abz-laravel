<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use function Tinify\fromFile;

class UserController
{
    public function index(Request $request)
    {
        $users = User::with('position')
            ->orderBy('id')
            ->paginate($request->input('count', 6));

        return response()->json([
            'success' => true,
            'page' => $users->currentPage(),
            'total_pages' => $users->lastPage(),
            'total_users' => $users->total(),
            'count' => $users->perPage(),
            'links' => [
                'next_url' => $users->nextPageUrl(),
                'prev_url' => $users->previousPageUrl(),
            ],
            'users' => $users->items(),
        ]);
    }

    public function show($id)
    {
        $user = User::with('position:id,name')->find($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'photo' => asset('uploads/photos/' . $user->photo),
                'position' => $user->position->name,
                'position_id' => $user->position_id,
            ]
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $file = $request->file('photo');
        $filename = uniqid() . '.jpg';
        $path = public_path('uploads/photos/' . $filename);

        Storage::disk('public_uploads')
            ->putFileAs('', $file, $filename);

        fromFile($path)
            ->resize([
                "method" => "fit",
                "width" => 70,
                "height" => 70
            ])->toFile($path);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position_id' => $request->position_id,
            'photo' => $filename,
            'password' => bcrypt('password'),
        ]);

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'message' => 'New user successfully registered',
        ], 201);
    }
}
