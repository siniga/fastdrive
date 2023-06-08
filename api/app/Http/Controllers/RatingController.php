<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::all();
        return response()->json($ratings);
    }

    public function show($id)
    {
        $rating = Rating::find($id);
        return response()->json($rating);
    }

    public function store(Request $request)
    {
        $rating = Rating::create($request->all());
        return response()->json($rating);
    }

    public function update(Request $request, $id)
    {
        $rating = Rating::find($id);
        $rating->update($request->all());
        return response()->json($rating);
    }

    public function destroy($id)
    {
        $rating = Rating::find($id);
        $rating->delete();
        return response()->json(['message' => 'Rating deleted']);
    }
}
