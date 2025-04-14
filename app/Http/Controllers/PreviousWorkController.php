<?php

namespace App\Http\Controllers;

use App\Http\Resources\PortfolioResource;
use App\Models\PreviousWork;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PreviousWorkController extends Controller
{
    public function index()
    {
        $previousWorks = PreviousWork::orderBy('id', 'desc')->where('hidden', 'yes')->get();

        if ($previousWorks->isEmpty()) {
            return response()->json(['error' => 'No previousWorks found'], 404);
        }

        return response()->json(PortfolioResource::collection($previousWorks));
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

            $filePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filePath = $image->store('portfolio', 'public');
            }

            $PreviousWorks = $admin->previousWorks()->create([
                'title' => $request->title,
                'image' => $filePath,
                'category' => $request->category,

            ]);

            return response()->json(['message' => 'Previous Work created successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create previous work'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $previousWork = PreviousWork::findOrFail($id);

            if (!$previousWork) {
                return response()->json(['error' => 'No previous work found with this ID'], 404);
            }

            return response()->json([
                'previousWork' => new PortfolioResource($previousWork)
            ]);
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
 
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($work->image);
                $image = $request->file('image');
                $filePath = $image->store('portfolio', 'public');
                $work->update(['image' => $filePath]);
            }

            return response()->json(['message' => 'portifolio updatd succefully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create previous work'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $previousWork = PreviousWork::findOrFail($id);
            $previousWork->delete();

            return response()->json(['message' => 'Previous work deleted successfully']);
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
        return response()->json(['message'=> 'the work is dleted']);
       } catch (ModelNotFoundException $e) {
        return response()->json(['error'=> 'server error'], 404);
       }catch (\Exception $e) {
        return response()->json(['error'=> 'please tray again'], 404);
       }
    }
}
