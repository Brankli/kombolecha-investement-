<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index(){
        $staffs = Staff::all();
        return response()->json(['message'=>'fetch successfully','staf'=>$staffs],200);
    }
    public function store(Request $request)
    {
        

        $user = Auth::user();
        $department = $user->departmentContents->first();

        if (!$department) {
            return response()->json(['message' => 'No department found for the user'], 403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:staff,email',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }
        $request->merge(['image' => $imageName]);
        
        $staff =Staff::create([
            'name' => $request->name,
            'position' => $request->position,
            'phone' => $request->phone,
            'email' => $request->email,
            'user_id' => $user->id,
             'dep_id' => $department->id,
            'image' => $request->image,
        ]);
            
        

        return response()->json(['message' => 'Staff created successfully', 'staff' => $staff], 201);
    }

    public function destroy( $id){
        $staff = Staff::find($id);
        if (!$staff) {
            return response()->json(['message' => 'Staff not found'], 404);
        }

        $staff->delete();

        return response()->json(['message' => 'Staff deleted successfully'], 200);

    }
}
 