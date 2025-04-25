<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsREsource;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function index()
    {
        try {
            $newses = News::orderBy('id', 'desc')->where('hidden','yes')->get();

            if ($newses->isEmpty()) {
                return response()->json(['message' => 'No news found'], 404);
            }

            return response()->json(NewsREsource::collection($newses));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch news'], 500);
        }catch(ModelNotFoundException $e) {
            return response()->json(['error'=> 'server error'], 404);
        }
    }

    public function show($id)
    {
        try {
            $news = News::findOrFail($id);

            if (!$news) {
                return response()->json(['message' => 'No news found'], 404);
            }

            return response()->json([
                'news' => new NewsREsource($news),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No news found with this ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch news'], 500);
        }
    }




    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:news|max:255',
            'content' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg|max:51200',
        ]);

        $admin = User::find(Auth::user()->id);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $filePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filePath = $image->store('news', 'public');
        }
        
        $news = $admin->news()->create([
            'title' => $request->title,
            'content' => $request->content,
            'info'=>'No contact',
            'image' => $filePath,
        ]);

        return response()->json(['message' => 'News created successfully'], 201);
    }


    public function edit($id)
    {
        $news = News::findOrFail($id);

        if (!$news) {
            return response()->json(['message' => 'No news found'], 404);
        }

        return response()->json([
            'news' => new NewsREsource($news),
        ]);
    }


public function update(Request $request, $id)
{
    $news = News::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'title' => 'required|max:255',  // Title is now required for update
        'content' => 'required',        // Content is now required for update
        'image' => 'nullable|mimes:jpeg,png,jpg', // Image is optional
    ]);

    try {
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Update the title and content
        $news->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // Handle image update if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image from storage
            Storage::disk('public')->delete($news->image);

            // Upload the new image and update the file path
            $image = $request->file('image');
            $filePath = $image->store('news', 'public');
            $news->update(['image' => $filePath]);
        }

        return response()->json(['message' => 'News updated successfully'], 200);

    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'No news found with this ID'], 404);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update news'], 500);
    }
}




    public function destroy($id)
    {
        try {
            $news = News::findOrFail($id);

            $news->delete();

            return response()->json(['message' => 'News deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No news found with this ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete news'], 500);
        }
    }

    public function hidden(Request $request){
        $newses = $request->id;
       try{
         foreach($newses as $news){
            $getnews =  News::findOrFail($news);
            $getnews->hidden = 'no';
            $getnews->save();
        }
        return response()->json(['message'=> 'the news is dleted'], 200);
       } catch (ModelNotFoundException $e) {
        return response()->json(['message'=> 'server error'], 404);
       }catch (\Exception $e) {
        return response()->json(['error'=> 'please tray again'], 404);
       }
    }
}
