<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class VisitorController extends Controller
{
    // GET /api/countvisitor
    public function index()
    {
        if (!Auth::user()) {
            return response()->json([
                'message' => 'unauthorized'
            ], 403);
        }

        try {
            $total = Visitor::count();
            return response()->json([
                'count' => $total
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong'
            ], 500);
        }
    }

    // POST /api/visitor
    public function store(Request $request)
    {

        $check = Visitor::query()
            ->where('ip_address', $request->ip())
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->first();

        if ($check) {
            return;
        }

        try {
            Visitor::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'message' => 'Visitor recorded'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to record visitor'
            ], 500);
        }
    }
}
