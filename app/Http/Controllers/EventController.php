<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Kullanıcının ait olduğu topluluğun etkinliklerini listele
    public function index()
    {
        $user = auth()->user();
        $events = Event::where('community_id', $user->community_id)->orderBy('event_date', 'asc')->get();

        return view('events.index', compact('events'));
    }

    // Yeni etkinlik oluşturma formu
    public function create()
    {
        return view('events.create');
    }

    // Yeni etkinlik kaydetme işlemi

    public function store(Request $request)
    {
        $request->validate([
            'community_id' => 'required|exists:communities,id', // Topluluk doğrulama
            'title' => 'required|max:255',
            'description' => 'nullable',
            'event_date' => 'required|date',
            'location' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Görsel doğrulama
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public'); // Görseli kaydet
        }

        Event::create([
            'community_id' => $request->community_id, // Kullanıcının seçtiği topluluk
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'image' => $imagePath,
        ]);

        return redirect()->route('events.index')->with('success', 'Etkinlik başarıyla oluşturuldu.');
    }


}
