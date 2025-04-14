<?php

namespace App\Http\Controllers;

use App\Http\Resources\MaterialResource;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ResourceController extends Controller
{
        public function index() {
        $Resource = Resource::orderBy('id', 'desc')->where('hidden', 'yes')->get();

        if ($Resource->isEmpty()) {
            return response()->json(['error' => 'No Resource found'], 404);
        }

        return response()->json([
            'resource' => MaterialResource::collection($Resource),
        ]);
    }

        public function store(Request $request)
    {
        $admin = User::find(Auth::user()->id);
        if (!$admin) {
            return response()->json(['error' => 'un Authorized'], 401);
        }

       $validations =  Validator::make($request->all(), [
            'title' => 'required|unique:previous_works|max:255',
            'resource' => 'required|mimes:jpeg,png,jpg,pdf,doc,txt',
        ]);

        $filePath = null;
        if ($request->hasFile('resource')) {
            $resource = $request->file('resource');
            $filePath = $resource->store('resource', 'public');
        }

        $resource = $admin->resources()->create([
            'resource'=> $filePath,
            'title'=> $request->title,
        ]);

        return response()->json(['message' => 'your resource uploaded successfully']);
    }
    

     public function destroy($id)
    {
        try {
            $Resource = Resource::findOrFail($id);

            $Resource->delete();

            return response()->json(['message' => 'noteBook deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No noteBook found '], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete noteBook'], 500);
        }
    }

    public function hidden(Request $request){
        $resources = $request->id;
       try{
         foreach($resources as $resource){
            $getresource =  Resource::findOrFail($resource);
            $getresource->hidden = 'no';
            $getresource->save();
        }
        return response()->json(['message'=> 'the noteBook is dleted']);
       } catch (ModelNotFoundException $e) {
        return response()->json(['error'=> 'server error'], 404);
       }catch (\Exception $e) {
        return response()->json(['error'=> 'please tray again'], 404);
       }
    }
}


