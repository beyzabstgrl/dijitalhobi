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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                // Görseli public klasörüne kaydet
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('events'), $imageName);
                $imagePath = 'events/' . $imageName; // Görselin yolu
            }

            // Etkinlik oluştur
            Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'event_date' => $request->event_date,
                'location' => $request->location,
                'community_id' => auth()->user()->community_id,
                'image' => $imagePath,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Etkinlik başarıyla oluşturuldu!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Etkinlik oluşturulurken bir hata oluştu!',
            ]);
        }
    }




}
