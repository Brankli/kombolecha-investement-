<?php

namespace App\Http\Controllers;
use App\Models\AnnouncEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class EventController extends Controller
{ 
    public function index()
    {
        try {
            $events = AnnouncEvent::orderBy('id', 'desc')->where('hidden','yes')->get();

            if ($events->isEmpty()) {
                return response()->json(['message' => 'No event or announcement found'], 404);
            }

            return response()->json(['events' => $events], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch event or announcement'], 500);
        }
    }

    public function show($id)
    {
        try {
            $event = AnnouncEvent::findOrFail($id);

            return response()->json(['event' => $event], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No news found with this ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch news'], 500);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event' => 'required',
            'type' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg|max:51200',
            'info'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }


        try {
            
            if ($request->hasFile('image')) {
                $image = time() . '.' . $request->image->extension();
                $request->image->move(public_path('EventsImage'), $image);

                $storeevent = new AnnouncEvent;
                $storeevent->author_id = Auth::user()->id;
                $storeevent->event = $request->event;
                $storeevent->type = $request->type;
                $storeevent->image =  'EventsImage/'.$image;
                $storeevent->info = $request->info;
                if($storeevent->save()){
                    return response()->json(['message' => 'event created successfully'], 201);
                }

                
            } else {
                return response()->json(['error' => 'Image is required'], 422);
            }
        } catch(ModelNotFoundException $e) {
            return response()->json(['error'=> 'server error'], 500);
        }
    }


    public function edit($id)
    {
        try {
            $event = AnnouncEvent::findOrFail($id);

            return response()->json(['event' => $event], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No events found with this ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch events'], 500);
        } catch(ModelNotFoundException $e) {
            return response()->json(['error'=> 'server error'], 500);
        }
    }
    public function update(Request $request, $id)
    {
            $event = AnnouncEvent::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'event' => 'required',
                'type' => 'required',
                'image' => 'mimes:jpeg,png,jpg',
                'info'=>'required'
            ]);

            try {
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

                $event->event = $request->event;
                $event->type = $request->type;
                $event->info = $request->info;

            $event->update($request->except('image'));
            if ($request->hasFile('image')) {
                $image = time() . '.' . $request->image->extension();
                $request->image->move(public_path('EventsImage'), $image);

                $event->image =  'EventsImage/'.$image;
            }
            if($event->save()){
                    return response()->json(['message' => 'event created successfully'], 201);
                }

            return response()->json(['message' => 'events updated successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No event found with this ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update event'], 500);
        }
    }



    public function destroy($id)
    {
        try {
            $event = AnnouncEvent::findOrFail($id);

            $event->delete();

            return response()->json(['message' => 'event deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No event found with this ID'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete event'], 500);
        }
    }

    public function hidden(Request $request){
        $events = $request->id;
       try{
         foreach($events as $event){
            $getevent =  AnnouncEvent::findOrFail($event);
            $getevent->hidden = 'no';
            $getevent->save();
        }
        return response()->json(['message'=> 'the event is dleted'], 200);
       } catch (ModelNotFoundException $e) {
        return response()->json(['message'=> 'server error'], 404);
       }catch (\Exception $e) {
        return response()->json(['error'=> 'please tray again'], 404);
       }
    }
}
