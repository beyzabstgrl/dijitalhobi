<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::all(); // Tüm toplulukları al
        return view('pages.communities', compact('communities'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $community = new Community();
        $community->name = $validated['name'];
        $community->description = $validated['description'] ?? null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('communities', 'public');
            $community->image = $path;
        }

        $community->save();

        return response()->json([
            'success' => true,
            'message' => 'Topluluk başarıyla eklendi.',
        ], 200);
    }
    public function edit($id)
    {
        $community = Community::findOrFail($id);
        return response()->json($community); // JSON formatında topluluk bilgilerini döndür
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $community = Community::findOrFail($id);
        $community->name = $validated['name'];
        $community->description = $validated['description'] ?? $community->description;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('communities', 'public');
            $community->image = $path;
        }

        $community->save();

        return response()->json([
            'success' => true,
            'message' => 'Topluluk başarıyla güncellendi.',
        ]);
    }

    public function destroy($id)
    {
        $community = Community::findOrFail($id);
        $community->delete();

        return response()->json([
            'success' => true,
            'message' => 'Topluluk başarıyla silindi.',
        ]);
    }


}
