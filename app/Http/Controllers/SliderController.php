<?php

namespace App\Http\Controllers;

use App\Http\Resources\sliderResource;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index(){
        $sliders=Slider::orderBy('order')->get();
        return response()->json([
            'data' => sliderResource::collection($sliders),
        ]);
      

    }
    public  function store(Request $request){      
          $filePath = null;


           $user= auth()->user();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:51200',
            'order' => 'nullable|integer',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image'); 
            $filePath = $image->store('images', 'public'); 
        }  

        $slider = Slider::create([
            'title'=> $request->title,
            'description'=> $request->description,
            'user_id'=> $user->id,
            'order'=> $request->order,
            'image' => $filePath,


        ]);
       

        return response()->json([
            'data' => $slider,
            'message' => 'Slider created successfully',
        ]);
    }
    public function edit($id){
        $slider=Slider::find($id);
     
        return response()->json([
            'data' => $slider,
        ]);
    }
    public function update(Request $request, $id){
        $slider=Slider::find($id);
        if (!$slider) {
            return response()->json(['message' => 'Slider not found'], 404);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:51200',
            'order' => 'nullable|integer',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
            $slider->image = $imagePath;
        }
        

        $slider->update([
            'title'=> $request->title,
            'description'=> $request->description,
            'order'=> $request->order,
            'user_id'=> auth()->user()->id,
            'image'=> $imagePath,

        ]);
       

        return response()->json([
            'data' => $slider,
            'message' => 'Slider updated successfully',
        ]);
    }
    public function destroy($id){
        $slider=Slider::find($id);
     
        $slider->delete();
        return response()->json([
            'message' => 'Slider deleted successfully',
        ]);
    }
}
