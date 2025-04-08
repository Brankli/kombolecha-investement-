<?php

namespace App\Http\Controllers;

use App\Models\PreviousWork;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PreviousWorkController extends Controller
{
    public function index()
    {
        try {
            $previousWorks = PreviousWork::orderBy('id', 'desc')->where('hidden','yes')->get();

            if ($previousWorks->isEmpty()) {
                return response()->json(['error' => 'No previousWorks found'], 404);
            }

            return response()->json($previousWorks);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch previousWorks'], 500);
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
            'image' => 'required|mimes:jpeg,png,jpg|max:51200',
            'category' => 'required',
        ]);

        
        try {
            if ($request->hasFile('image')) {
                $image = time() . '.' . $request->image->extension();
                $request->image->move(public_path('PreviousWorkImage'), $image);
                $image_src = 'PreviousWorkImage/'.$image;

                $PreviousWorks = $admin->previousWorks()->create([
                    'title' => $request->title,
                    'image' => $image_src,
                    'category' => $request->category,

                ]);

                return response()->json(['message' => 'Previous Work created successfully'], 200);
            } else {
                return response()->json(['error' => 'Please upload image'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create previous work'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $previousWork = PreviousWork::findOrFail($id);

            return response()->json(['previousWork' => $previousWork], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No previous work found with this ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch previous work'], 500);
        }
    }

    public function update(Request $request,$id)
    {
        try {
        $work = PreviousWork::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'max:255',
            'image' => 'mimes:jpeg,png,jpg|max:51200',
            'category' => 'max:255',
        ]);

        
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            $work->update($request->except('image'));

            if ($request->hasFile('image')) {
                $image = time() . '.' . $request->image->extension();
                $request->image->move(public_path('NewsImage'), $image);
                $work->update(['image' => 'NewsImage/' . $image]);                
            } 
            return response()->json(['message' => 'portifolio updatd succefully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create previous work'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $previousWork = PreviousWork::findOrFail($id);
            $previousWork->delete();

            return response()->json(['message' => 'Previous work deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No previous work found with this ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete previous work'], 500);
        }
    }
    public function hidden(Request $request){
        $works = $request->id;
       try{
         foreach($works as $work){
            $getwork =  PreviousWork::findOrFail($work);
            $getwork->hidden = 'no';
            $getwork->save();
        }
        return response()->json(['message'=> 'the work is dleted'], 200);
       } catch (ModelNotFoundException $e) {
        return response()->json(['error'=> 'server error'], 404);
       }catch (\Exception $e) {
        return response()->json(['error'=> 'please tray again'], 404);
       }
    }
}
