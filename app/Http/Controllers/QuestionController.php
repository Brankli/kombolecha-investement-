<?php

namespace App\Http\Controllers;

use App\Mail\AnsewerMail;
use App\Models\Question;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function index()
    {
        try {
            $questions = Question::orderBy('id', 'desc')->get();

            if ($questions->isEmpty()) {
                return response()->json(['message' => 'No questions found'], 404);
            }

            return response()->json($questions);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch questions'], 500);
        }
    }
    public function totalquestions()
    {
        try {
            $countquestions = Question::count();

            if (!$countquestions) {
                return response()->json(['message' => 'No questions found'], 404);
            }

            return response()->json($countquestions);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch questions'], 500);
        }
    }
    public function edit($id)
    {
        try {
            $question = Question::findOrFail($id);
            return response()->json(['question' => $question], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch question'], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'email' => 'required',
            'phone_no' => 'required|',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'all filds are required'], 422);
        }

        
        // try {

            $question = new Question;
            $question->question = $request->question;
            $question->email = $request->email;
            $question->phone_no = $request->phone_no;

            
            if($question->save()){

                return response()->json(['message' => 'Question created successfully'], 201);
            }
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Failed to create question'], 500);
        // }
    }
 
    public function answer(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'answer' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {

            $question = Question::findOrFail($id);

            $emailed = Mail::to($question->email)->send(new AnsewerMail($request->answer,$question->email,$question->question));
            $question->is_answered = 'yes';
            
            if ($question->save() && $emailed) {
                return response()->json(['message' => 'Email sent successfully'], 201);
                
            }

            return response()->json(['message' => 'Question answered successfully'], 201);
        } catch(ModelNotFoundException $e) {
            return response()->json(['error'=> 'server error'], 500);
        }catch (\Exception $e) {
            return response()->json(['error' => 'Failed to answer question'], 500);
        }
    }
}
