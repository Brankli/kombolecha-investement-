<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Models\DepartmentContent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use App\Models\User;

class DepartmentContentroller extends Controller
{
    // List all department contents (single record in your case)
    public function index()
    {
        $departmentContents = DepartmentContent::first();

        if (! $departmentContents) {
            return response()->json(['message' => 'No DepartmentContent found'], 404);
        }

        return response()->json([
            'data' => new DepartmentResource($departmentContents),
        ]);
    }

    // Fetch one for editing
    public function edit($id)
    {
        try {
            $departmentContent = DepartmentContent::findOrFail($id);

            return response()->json([
                'DepartmentContent' => new DepartmentResource($departmentContent),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No DepartmentContent found with this ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch DepartmentContent'], 500);
        }
    }

    // Create new department content
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'profile'  => 'required|mimes:jpeg,png,jpg|max:51200',
            'email'    => 'required|email|max:255',
            'phone_no' => 'required|string|max:50',
            'vision'   => 'required|string',
            'mission'  => 'required|string',
            'goal'     => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Handle profile upload
            $filePath = $request->file('profile')->store('staff', 'public');

            $dept = DepartmentContent::create([
                'name'     => $request->name,
                'profile'  => $filePath,
                'email'    => $request->email,
                'phone_no' => $request->phone_no,
                'vision'   => $request->vision,
                'mission'  => $request->mission,
                'goal'     => $request->goal,
            ]);

            return response()->json([
                'message' => 'DepartmentContent created successfully',
                'data'    => new DepartmentResource($dept),
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create DepartmentContent'], 500);
        }
    }

    // Update existing
    public function update(Request $request, $id)
    {
       $departmentContent = DepartmentContent::findOrFail($id);

            $validator = Validator::make($request->all(), [
               
                'vision'   => 'required|string',
                'mission'  => 'required|string',
                'goal'     => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Update fields
             

            $departmentContent->update([ 
                'vission'   => $request->vision,
                'mission'  => $request->mission,
                'goal'     => $request->goal,
            ]);

            // Handle new profile image
            if ($request->hasFile('profile')) {
                // delete old
                Storage::disk('public')->delete($departmentContent->profile);
                // store new
                $departmentContent->profile = $request->file('profile')
                    ->store('staff', 'public');
            }

            $departmentContent->save();

            return response()->json(['message' => 'DepartmentContent updated successfully']);
    }

    // Delete (if needed)
    public function destroy($id)
    {
        try {
            $departmentContent = DepartmentContent::findOrFail($id);
            Storage::disk('public')->delete($departmentContent->profile);
            $departmentContent->delete();

            return response()->json(['message' => 'DepartmentContent deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'DepartmentContent not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete DepartmentContent'], 500);
        }
    }

    // Existing getStaffs method
    public function getStaffs()
    {
        $departmentHead     = User::query()->has('director')->first();
        $mineralDirector    = User::query()->has('miniral')->first();
        $expansionDirector  = User::query()->has('expansion')->first();
        $developmentDirector = User::query()->has('development')->first();

        return response()->json([
            'departmentHead'      => new UserResource($departmentHead),
            'mineralDirector'     => new UserResource($mineralDirector),
            'expansionDirector'   => new UserResource($expansionDirector),
            'developmentDirector' => new UserResource($developmentDirector),
        ]);
    }
}
