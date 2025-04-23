<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Http\Resources\UserResource;
use App\Models\DepartmentContent;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DepartmentContentroller extends Controller
{

    public function index() {
        $departmentContents = DepartmentContent::first();

        if (!$departmentContents) {
            return response()->json(['message' => 'No DepartmentContent found'], 404);
        }
 

        return response()->json([
            'data'  => new DepartmentResource($departmentContents),
        ]);
    }

    public function edit($id)
    {
        try {
            $DepartmentContent = DepartmentContent::findOrFail($id);

            return response()->json([
                'DepartmentContent' => new DepartmentResource($DepartmentContent),
            ]);
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

                Storage::disk('public')->delete($DepartmentContent->profile);

                $image = $request->file('profile');
                $filePath = $image->store('staff', 'public');

                $DepartmentContent->profile =  $filePath;
            } 

            if($DepartmentContent->save()){
                return response()->json(['message' => 'DepartmentContent updated successfully'
            ]);
            }else{
                return response()->json(['message'=> 'department not updated'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update DepartmentContent'], 500);
        }catch(ModelNotFoundException $e){
            return response()->json(['error'=> 'server error'], 500);
        }
    }


    public function getStaffs() { 
     
        $departmentHead = User::query()
                ->has('director')
                ->first();
        $mineralDirector    = User::query()
                ->has('miniral')
                ->first();
        $expansionDirector  = User::query()
            ->has('expansion')
            ->first();
        $developmentDirector = User::query()
            ->has('development')
            ->first();

        return response()->json([ 

            'departmentHead'      => new UserResource($departmentHead),
            'mineralDirector'     => new UserResource($mineralDirector),
            'expansionDirector'   => new UserResource($expansionDirector),
            'developmentDirector' => new UserResource($developmentDirector),
        ]);
    }
}
