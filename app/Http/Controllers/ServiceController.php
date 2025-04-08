<?php

namespace App\Http\Controllers;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ServiceController extends Controller
{

    public function index(){
        try{
            $service = Service::orderBy('id', 'desc')->get();

            if($service->isEmpty()){
                return response()->json(['message'=>'no service is found'],422);
            }
            return response()->json(['services'=> $service],200);
        } catch(ModelNotFoundException $e){
            return response()->json(['message'=> 'service not found'],404);
        }catch(\Exception $e){
            return response()->json(['message'=> 'sorry, fail to fech service'],500);
        }
    }
        public function edit($id)
    {
        try {
            $content = Service::findOrFail($id);

            return response()->json(['service' => $content], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Content not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch content'], 500);
        }
    }
        public function update(Request $request, $id)
    {

        try{
            $service = Service::find($id);
        $service->service = $request->service;
        $service->department = $request->department;

        if($service->save()){
            return response()->json(['message'=> 'updated succefully'],200);
        }else{
            return response()->json(['error'=> 'errorr occur'],500);
        }
        } catch (ModelNotFoundException $e){
            return response()->json(['error'=> 'exception occur'],500);
        }
        
    }
}


