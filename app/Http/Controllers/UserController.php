<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = User::find(1)->get();

            if ($user->isEmpty()) {
                return response()->json(['message' => 'No user found'], 404);
            }

            return response()->json(UserResource::collection($user));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch user'], 500);
        }
    }
    public function edit($id)
    {
        try {
            $user = Auth::user();

            return response()->json([
                'user' => new UserResource($user)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'not found with this ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'srver error'], 500);
        }
    }

    public function update(Request $request,$id)
    {
        try {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'image' => 'mimes:jpeg,png,jpg|max:51200',
            'phone_no' => 'max:255',
        ]);

        
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            $user->name = $request->name;
            $user->phone_no = $request->phone_no; 
 
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($user->image);

                $image = $request->file('image');
                $filePath = $image->store('portfolio', 'public');
                $user->image = $filePath;
            }

            if($user->save()){
                return response()->json([
                    'message' => 'profile updated successfully'
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create previous work'], 500);
        }
    }

}
