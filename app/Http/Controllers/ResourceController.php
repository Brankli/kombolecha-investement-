<?php

namespace App\Http\Controllers;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ResourceController extends Controller
{
        public function index()
    {
        try {
            $Resource = Resource::orderBy('id', 'desc')->where('hidden','yes')->get();

            if ($Resource->isEmpty()) {
                return response()->json(['error' => 'No Resource found'], 404);
            }

            return response()->json(['resource' => $Resource], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch Resource'], 500);
        }
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

        
        // try {
            if ($request->hasFile('resource')) {
                $image = time() . '.' . $request->resource->extension();
                $request->resource->move(public_path('Resource'), $image);
                $image_src = 'Resource/'.$image;

                $resource = $admin->resources()->create([
                    'resource'=>$image_src,
                    'title'=> $request->title,
                ]);

                return response()->json(['message' => 'your resource uploaded successfully'], 200);
            } else {
                return response()->json(['error' => 'Please upload file'], 422);
            }
        // }catch (ModelNotFoundException $e) {
        //     return response()->json(['error' => 'model exception error'], 500);
        // }
        // catch (\Exception $e) {
        //     return response()->json(['error' => 'Failed to upload the file please try again'], 500);
        // }
    }
    

     public function destroy($id)
    {
        try {
            $Resource = Resource::findOrFail($id);

            $Resource->delete();

            return response()->json(['message' => 'noteBook deleted successfully'], 200);
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
        return response()->json(['message'=> 'the noteBook is dleted'], 200);
       } catch (ModelNotFoundException $e) {
        return response()->json(['error'=> 'server error'], 404);
       }catch (\Exception $e) {
        return response()->json(['error'=> 'please tray again'], 404);
       }
    }
}


