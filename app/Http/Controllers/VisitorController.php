<?php

namespace App\Http\Controllers;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class VisitorController extends Controller
{
   public function index(){
      if(!Auth::user()){
         return response()->json([
         'message'=>'unAuthorized'
      ],403);
      }
      try{
         $visitors = Visitor::count();
      return response()->json([
         $visitors
      ],200);
      }catch(\Exception $e){
         return response()->json([
         'err'=>'somthing happen'
      ],500);
      }catch(ModelNotFoundException $e){
         return response()->json([
         'err'=>'server error'
      ],500);
      }
   }
   public function store(Request $request){
    $ip = $request->ip();
    $user_agent = $request->userAgent();
    
    $visitor = Visitor::create([
      'ip_address'=>$ip,
      'user_agent'=>$user_agent,
      'created_at'=>Carbon::now(),
    ]);
    return response()->json([
      'message'=>'succefully accessed'
    ],200);
   }
}
