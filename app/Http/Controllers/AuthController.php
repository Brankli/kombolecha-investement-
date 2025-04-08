<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Hash; 
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login(Request $request){

       $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        try {
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json([
                    'message' => 'invalid credentials! please try again'
                ], 401);
            }

            $user = $request->user();


            $tokenData = $user->createToken($request->email);
            return response()->json([
                'access_token' => $tokenData->accessToken, 'user' => Auth::user(),
            ]);
        } catch (\ErrorException $e) {
            return $e;
        }
        
    }

    public function resetlink(Request $request){
       $email = $request->validate([
            'email'=>'required|email',
        ]);

        $user = User::where('email',$request->email)->firstOrFail();

        if(!$user){
            return response()->json(['error'=>'please use your email'],500);
        }
        $remrnbertoken = Str::random(60);

        try{
            Mail::to($request->email)->send(new ResetPassword($remrnbertoken));
            $user->remember_token	= $remrnbertoken;
            $user->save();
            return response()->json(['message'=>'succefull please chack your email'],200);
        }catch(\Exception $e){
            return response()->json(['error'=> $e->getMessage()],500);
        }catch(ModelNotFoundException $e){
            return response()->json(['error'=> 'server error'],500);
        }
    }
    public function changepassword(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'password' => 'min:4|required|confirmed',
        ]);        

        $str =Str::random(60);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }


        try{
            $user = User::where('remember_token',$id)->firstOrFail();
        $user->remember_token = $str;
        $user->password = $request->password;
        $user->save();
        return response()->json(['message'=>'password changed succefully'],200);
        } catch(\Exception $e){
             return response()->json(['error'=> 'please confirm your email'], 500);
        }
    }
}
