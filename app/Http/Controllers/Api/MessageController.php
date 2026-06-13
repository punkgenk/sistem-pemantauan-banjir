<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /*
    |------------------------------------------------------------------
    | Kolom tabel messages:
    | id, conversation_id, sender_id, message (text),
    | image (string path), is_read (boolean), timestamps
    |------------------------------------------------------------------
    */

    // GET /api/chat/{conversation}/messages
    public function index(Request $request, Conversation $conversation)
    {
        // Pastikan user adalah bagian dari conversation ini
        if (! $this->isMember($request->user()->id, $conversation)) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        // Mark pesan dari lawan bicara sebagai sudah dibaca
        Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $request->user()->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where('conversation_id', $conversation->id)
            ->oldest()
            ->get()
            ->map(fn ($m) => $this->format($m));

        return response()->json(['data' => $messages]);
    }

    // POST /api/chat/{conversation}
    public function store(Request $request, Conversation $conversation)
    {
        if (! $this->isMember($request->user()->id, $conversation)) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $data = $request->validate([
            'message' => 'nullable|string|max:2000',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Minimal salah satu harus ada
        if (empty($data['message']) && ! $request->hasFile('image')) {
            return response()->json([
                'message' => 'Pesan atau gambar wajib diisi.',
            ], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat-images', 'public');
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $request->user()->id,
            'message'         => $data['message'] ?? null,
            'image'           => $imagePath,
            'is_read'         => false,
        ]);

        // Update timestamp conversation agar muncul di atas list
        $conversation->touch();

        return response()->json([
            'data' => $this->format($message),
        ], 201);
    }

    // Cek apakah user adalah bagian dari conversation
    private function isMember(int $userId, Conversation $conv): bool
    {
        return $conv->masyarakat_id === $userId
            || $conv->pemerintah_id === $userId;
    }

    // Format response
    private function format(Message $m): array
    {
        return [
            'id'              => $m->id,
            'conversation_id' => $m->conversation_id,
            'sender_id'       => $m->sender_id,
            'body'            => $m->message, // alias 'body' untuk Flutter
            'message'         => $m->message,
            'image_url'       => $m->image ? Storage::url($m->image) : null,
            'is_read'         => $m->is_read,
            'created_at'      => $m->created_at,
        ];
    }
}
