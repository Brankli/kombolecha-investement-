<?php

namespace App\Http\Controllers;

use App\Models\DepartmentContent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentContentroller extends Controller
{

    public function index()
    {
        try {
            $DepartmentContents = DepartmentContent::orderBy('id', 'desc')->paginate(10);

            if ($DepartmentContents->isEmpty()) {
                return response()->json(['message' => 'No DepartmentContent found'], 404);
            }

            return response()->json(['DepartmentContent' => $DepartmentContents], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch DepartmentContent'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $DepartmentContent = DepartmentContent::findOrFail($id);

            return response()->json(['DepartmentContent' => $DepartmentContent], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No DepartmentContent found with this ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch DepartmentContent'], 500);
        }
    }

    public function update(Request $request, $id)
    {  
         $DepartmentContent = DepartmentContent::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'profile' => 'mimes:jpeg,png,jpg|max:51200',
            'email' => 'required|email',
            'phone_no' => 'required',
            'vission' => 'required',
            'mission' => 'required',
            'goal' => 'required',
        ]);
         try {
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
            $DepartmentContent->name = $request->name;
            $DepartmentContent->email = $request->email;
            $DepartmentContent->vission = $request->vission;
            $DepartmentContent->mission = $request->mission;
            $DepartmentContent->goal = $request->goal;
            $DepartmentContent->phone_no = $request->phone_no;


            if ($request->hasFile('profile')) {
                $profile = time() . '.' . $request->profile->extension();
                $request->profile->move(public_path('DepartmentContentLogo'), $profile);

                $DepartmentContent->profile = 'DepartmentContentLogo/' . $profile;
            } 
            if($DepartmentContent->save()){
                return response()->json(['message' => 'DepartmentContent updated successfully'], 200);
            }else{
                return response()->json(['message'=> 'department not updated'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update DepartmentContent'], 500);
        }catch(ModelNotFoundException $e){
            return response()->json(['error'=> 'server error'], 500);
        }
    }
}
