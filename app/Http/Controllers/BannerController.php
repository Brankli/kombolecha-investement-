<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index()
    {

            $banners = Banner::orderBy('id', 'desc')->where('hidden','yes')->get();

            if ($banners->isEmpty()) {
                return response()->json(['message' => 'No banner found'], 404);
            }

            return response()->json($banners);

    }

    public function store(Request $request)
    {

        $admin = User::find(Auth::user()->id);
        if (!$admin) {
            return response()->json(['message' => 'un Authorized'], 401);
        }

       $validations =  Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,png,jpg|max:100000',
        ]);



            if ($request->hasFile('image')) {
                $image = time() . '.' . $request->image->extension();
                $request->image->move(public_path('PreviousWorkImage'), $image);
                $image_src = 'PreviousWorkImage/'.$image;

                $banners = $admin->banner()->create([

                    'image' => $image_src,
                    'created_at'=>Carbon::now(),
                ]);

                return response()->json(['message' => 'new banner added successfully'], 201);
            } else {
                return response()->json(['message' => 'Please upload banner photo'], 422);
            }

    }

    public function hidden(Request $request){
        $banners = $request->id;
       try{
         foreach($banners as $banner){
            $getbanner =  Banner::findOrFail($banner);
            $getbanner->hidden = 'no';
            $getbanner->updated_at = Carbon::now();
            $getbanner->save();
        }
        return response()->json(['message'=> 'The banner is removed'], 200);
       } catch (ModelNotFoundException $e) {
        return response()->json(['message'=> 'server error'], 404);
       }catch (\Exception $e) {
        return response()->json(['error'=> 'please tray again'], 500);
       }
    }
}