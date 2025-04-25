<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestimonialResource;
use App\Models\Testimonail;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TestimonailController extends Controller
{
    public function index()
    {
        try {
            $testimonails = Testimonail::orderBy('id', 'desc')
                ->where('hidden', 'yes')
                ->get();

            if ($testimonails->isEmpty()) {
                return response()->json(['message' => 'No testimonial found'], 404);
            }

            return response()->json(TestimonialResource::collection($testimonails));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch testimonial'], 500);
        }
    }

    public function store(Request $request)
    {
        $admin = Auth::user();
        if (!$admin) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validations = Validator::make($request->all(), [
            'Name'         => 'required|string|max:255',
            'discribution' => 'required|string',
            'image'        => 'required|image|mimes:jpeg,png,jpg|max:51200',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors()], 422);
        }

        try {
            $filePath = null;
            if ($request->hasFile('image')) {
                $filePath = $request->file('image')
                    ->store('testimonials', 'public');
            }

            $admin->testimonail()->create([
                'Name'         => $request->Name,
                'discribution' => $request->discribution,
                'image'        => $filePath,
                'created_at'   => Carbon::now(),
            ]);

            return response()->json(
                ['message' => 'New testimonial added successfully'],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Failed to create testimonial'],
                500
            );
        }
    }

    /**
     * Bulk-hide (set hidden = 'no') selected testimonials.
     */
    public function hidden(Request $request)
    {
        $ids = $request->input('id', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(
                ['message' => 'No testimonial IDs provided.'],
                422
            );
        }

        try {
            foreach ($ids as $id) {
                $t = Testimonail::findOrFail($id);
                $t->hidden     = 'no';
                $t->updated_at = Carbon::now();
                $t->save();
            }
            return response()->json([
                'message' => count($ids) . ' testimonial(s) hidden successfully.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                ['message' => 'One or more testimonials not found.'],
                404
            );
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Please try again.'],
                500
            );
        }
    }

    /**
     * Update a single testimonial (called by Edit modal).
     */
    public function update(Request $request, $id)
    {
        // Validate inputs
        $validations = Validator::make($request->all(), [
            'Name'         => 'required|string|max:255',
            'discribution' => 'required|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:51200',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors()], 422);
        }

        try {
            $testimonial = Testimonail::findOrFail($id);

            // Handle new image
            if ($request->hasFile('image')) {
                // Delete old file if exists
                if (
                    $testimonial->image &&
                    Storage::disk('public')->exists($testimonial->image)
                ) {
                    Storage::disk('public')->delete($testimonial->image);
                }
                // Store new
                $testimonial->image = $request->file('image')
                    ->store('testimonials', 'public');
            }

            // Update fields
            $testimonial->Name         = $request->Name;
            $testimonial->discribution = $request->discribution;
            $testimonial->updated_at   = Carbon::now();
            $testimonial->save();

            return response()->json([
                'message' => 'Testimonial updated successfully.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                ['message' => 'Testimonial not found.'],
                404
            );
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Failed to update testimonial, please try again.'],
                500
            );
        }
    }

    /**
     * Permanently delete a testimonial (and its image).
     */
    public function destroy($id)
    {
        try {
            $testimonial = Testimonail::findOrFail($id);

            if (
                $testimonial->image &&
                Storage::disk('public')->exists($testimonial->image)
            ) {
                Storage::disk('public')->delete($testimonial->image);
            }

            $testimonial->delete();

            return response()->json([
                'message' => 'Testimonial deleted successfully.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                ['message' => 'Testimonial not found.'],
                404
            );
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Failed to delete testimonial, please try again.'],
                500
            );
        }
    }
}
