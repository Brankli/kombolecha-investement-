<?php

namespace App\Http\Controllers;

use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return response()->json([
            'data' => SliderResource::collection($sliders),
        ]);
    }

public function store(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'order' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:51200', // Adjust validation for image
    ]);

    // Handle image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        // Store the image and get the file path
        $image = $request->file('image');
        $imagePath = $image->store('sliders', 'public'); // Store in public disk and return path
    }

    // Create a new slider
    $slider = new Slider();
    $slider->title = $request->input('title');
    $slider->description = $request->input('description');
    $slider->order = $request->input('order');
    $slider->image = $imagePath;  // Store the image path in the database

    // Assign user_id from authenticated user
    $slider->user_id = auth()->id(); // Ensure user is authenticated

    // Save the slider to the database
    $slider->save();

    return response()->json(['message' => 'Slider created successfully', 'slider' => $slider], 201);
}



    public function edit($id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json(['message' => 'Slider not found'], 404);
        }

        return response()->json([
            'data' => $slider,
        ]);
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return response()->json(['message' => 'Slider not found'], 404);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:51200',
            'order'       => 'nullable|integer',
        ]);

        $imagePath = $slider->image; // Keep old image unless new one uploaded

        if ($request->hasFile('image')) {
            // Delete old image
            if ($slider->image && Storage::exists("public/{$slider->image}")) {
                Storage::delete("public/{$slider->image}");
            }

            // Upload new image
            $image = $request->file('image');
            $imagePath = $image->store('sliders', 'public');
        }

        $slider->update([
            'title'       => $request->title,
            'description' => $request->description,
            'order'       => $request->order,
            'image'       => $imagePath,
            'user_id'     => auth()->user()->id ?? null, // Optional: only if user_id exists in table
        ]);

        return response()->json([
            'data'    => $slider,
            'message' => 'Slider updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return response()->json(['message' => 'Slider not found'], 404);
        }

        // Delete the image if it exists
        if ($slider->image && Storage::exists("public/{$slider->image}")) {
            Storage::delete("public/{$slider->image}");
        }

        $slider->delete();

        return response()->json([
            'message' => 'Slider deleted successfully',
        ]);
    }
}
