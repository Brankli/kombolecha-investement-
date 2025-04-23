<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = User::query()
                ->doesntHave('admin')
                ->get();


            if ($user->isEmpty()) {
                return response()->json(['message' => 'No user found'], 404);
            }

            return response()->json(UserResource::collection($user));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch user'], 500);
        }
    }
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone_no' => 'required|string|max:20',
        'position' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:51200',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        $imagePath = 'images/no_profile.png';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'position' => $request->position,
            'password' => Hash::make('defaultPassword123'),
            'role' => 'ourStaff',
            'image' => $imagePath,
        ]);

        $user->ourStaf()->create();

        return response()->json(['message' => 'Staff user created successfully', 'data' => $user->load('ourStaf')]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to create staff user: ' . $e->getMessage()], 500);
    }
}

    // public function edit($id)
    // {
    //     try {
    //         $user = Auth::user();

    //         return response()->json([
    //             'user' => new UserResource($user)
    //         ]);
    //     } catch (ModelNotFoundException $e) {
    //         return response()->json(['message' => 'not found with this ID'], 404);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'srver error'], 500);
    //     }
    // }

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id); 
            return response()->json([
                'user' => new UserResource($user)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'max:255',
                'image' => 'mimes:jpeg,png,jpg|max:51200',
                'phone_no' => 'max:255',
                'email' => 'email',
                'position' => 'max:255',
            ]);


            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            $user->name = $request->name;
            $user->phone_no = $request->phone_no;

            if ($request->hasFile('image')) {
                if (!empty($user->image)) {
                    Storage::disk('public')->delete($user->image);
                }

                $image = $request->file('image');
                $filePath = $image->store('portfolio', 'public');
                $user->image = $filePath;
            }

            if ($user->save()) {
                return response()->json([
                    'message' => 'profile updated successfully'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
            return response()->json(['error' => 'Failed to create profile'], 500);
        }
    



    public function getUsersByRole($role)
    {
       
        $user = User::query()
            ->whereHas($role)
            ->first();

        if (!$user) {
            return response()->json([
                'message' => 'No user found for this role.'
            ], 404);
        }

        return response()->json([
            'data' => new UserResource($user),
            'multiple' => false
        ]);
    }

    public function getStaffs() {
        $users = User::query()
            ->whereHas('ourStaf')
            ->get();

        if (!$users) {
            return response()->json([
                'message' => 'No user found for this role.'
            ], 404);
        }

        return response()->json([
            'data' => UserResource::collection($users)
        ]);
    }
}
