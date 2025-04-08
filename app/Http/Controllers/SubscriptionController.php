<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailgeBrodcaster;
use App\Models\Allmessage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class SubscriptionController extends Controller
{
    public function index()
    {
        try {
            $subscribers = Subscription::count();
            if (!$subscribers) {
                return response()->json(['message' => "No Subscriber found"], 404);
            }

            return response()->json(['subscribers' => $subscribers]);
        } catch (\Exception $th) {
            return response()->json(['error' => 'failed to fetch subscribers'], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', Rule::unique('subscriptions')],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'please insert your email for new subscriber'], 422);
        }

        try {
            $subscriber = Subscription::create($request->all());
            return response()->json(['message' => 'You are subscribed successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to subscribe. Email may already be taken.'], 500);
        }
    
    }
    public function broadcast(Request $request){
        $admin = User::find(Auth::user()->id);
        $validtor = validator::make($request->all(),[
            'message'=>'required'
        ]);

        if ($validtor->fails()) {
            return response()->json(['error'=> $validtor->errors()],422);
        }

        $subscribers = Subscription::pluck('email')->toArray();


        try{
            foreach($subscribers as $subscriber){
                Mail::to($subscriber)->send(new EmailgeBrodcaster($request->message, $subscriber));    
            }
            $admin->allmessages()->create([
                    'message'=>$request->message,
                    'type'=>'message'
                ]);
                return response()->json(['message'=>'your message is brodcasted']);            
        } catch(ModelNotFoundException $e) {
            return response()->json(['message'=> 'model not found error'], 404);
        }

}
   
}