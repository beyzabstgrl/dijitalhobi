<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $eventId)
    {

        $request->validate([
            'comment' => 'required|string|max:500', // Yorum içeriği zorunlu
        ]);

        Comment::create([
            'event_id' => $eventId, // Rota parametresinden alınıyor
            'user_id' => auth()->id(), // Giriş yapan kullanıcının ID'si
            'comment' => $request->comment, // Yorum içeriği
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Yorum başarıyla eklendi.',
        ]);
    }

}
