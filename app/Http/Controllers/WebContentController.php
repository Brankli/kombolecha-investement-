<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WebContent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WebContentController extends Controller
{
    public function index()
    {
        try {
            $WebContents = WebContent::orderBy('id', 'desc')->paginate(10);

            if ($WebContents->isEmpty()) {
                return response()->json(['message' => 'No WebContents found'], 404);
            }

            return response()->json(['WebContents' => $WebContents], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch WebContents'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $WebContent = WebContent::findOrFail($id);

            return response()->json(['WebContent' => $WebContent], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No WebContent found with this ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch WebContent'], 500);
        }
    }

    public function update(Request $request, $id)
    {

        $admin = User::find(Auth::user()->id);

        if (!$admin) {
            return response()->json(['message' => 'un Authorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'logo' => 'mimes:jpeg,png,jpg',
            'amharicname' => 'required',
            'email' => 'required|email',
            'phone_no' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        };
        try {


            $WebContent = WebContent::findOrFail($id);
            $WebContent->name = $request->name;
            $WebContent->email = $request->email;
            $WebContent->phone_no = $request->phone_no;
            $WebContent->amharicname = $request->amharicname;

            if ($request->hasFile('logo')) {
                $logo = time() . '.' . $request->logo->extension();
                $request->logo->move(public_path('WebsiteLogo'), $logo);
                $WebContent->logo ='WebsiteLogo/' . $logo;
            }

            if($WebContent->save()){
                return response()->json(['message' => 'WebContent updated successfully'], 200);
            }else{
                return response()->json(['message'=> 'webcontent not updated'], 400);
            }

                
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No WebContent found with this ID'], 404);
        } catch(\Exception $e) {
            return response()->json(['message'=> 'fil to update']);
        }
    }
}
