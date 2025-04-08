<?php

namespace App\Http\Controllers;

use App\Models\Sponser;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
// Removed duplicate and incorrect import
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class SponserController extends Controller
{
     public function index()
    {
        try {
            $sponsers = Sponser::orderBy('id', 'desc')->where('hidden','yes')->get();

            if ($sponsers->isEmpty()) {
                return response()->json(['message' => 'No Sponsor found'], 404);
            }

            return response()->json($sponsers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch Sponsor'], 500);
        }catch(ModelNotFoundException $e){
            return response()->json(['error'=> 'server error sponsor'], 404);
        }
    }

    public function store(Request $request)
    {

        $admin = User::find(Auth::user()->id);
        if (!$admin) {
            return response()->json(['message' => 'un Authorized'], 401);
        }

       $validations =  Validator::make($request->all(), [
            'CompanyName' => 'required|unique:previous_works|max:255',
            'image' => 'required|mimes:jpeg,png,jpg|max:51200',
        ]);

        
        $user=auth::user();
        // dd($user);
        try{
            if ($request->hasFile('image')) {
                $image = time() . '.' . $request->image->extension();
                $request->image->move(public_path('PreviousWorkImage'), $image);
                $image_src = 'PreviousWorkImage/'.$image;

                $sponsers = $admin->sponsers()->create([
                    'CompanyName' => $request->CompanyName,
                    'image' => $image_src,
                    // 'author_id' => $user->id,
                    'created_at' => Carbon::now(),
                ]);

                return response()->json(['message' => 'new sponser added successfully'], 201);
            } else {
                return response()->json(['message' => 'Please upload image'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create sponsor '], 500);
        }catch(ModelNotFoundException $e){
            return response()->json(['error'=> 'server error sponsor'], 404);
        }
    }

    public function hidden(Request $request){
        $sponseers = $request->id;
       try{
         foreach($sponseers as $sponser){
            $getsponser =  Sponser::findOrFail($sponser);
            $getsponser->hidden = 'no';
            $getsponser->updated_at = Carbon::now();
            $getsponser->save();
        }
        return response()->json(['message'=> 'the sponsor is removed'], 200);
       } catch (ModelNotFoundException $e) {
        return response()->json(['message'=> 'server error'], 404);
       }catch (\Exception $e) {
        return response()->json(['error'=> 'please tray again'], 500);
       }
    }
}
