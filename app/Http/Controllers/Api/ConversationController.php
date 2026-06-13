<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /*
    |------------------------------------------------------------------
    | Kolom tabel conversations:
    | id, masyarakat_id, pemerintah_id, timestamps
    | UNIQUE: (masyarakat_id, pemerintah_id)
    |------------------------------------------------------------------
    */

    // GET /api/chat — list conversation milik user yang login
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'masyarakat') {
            // Masyarakat: lihat conversation miliknya
            $conversations = Conversation::with(['pemerintah', 'lastMessage'])
                ->where('masyarakat_id', $user->id)
                ->latest()
                ->get()
                ->map(fn ($c) => $this->format($c, $user));
        } else {
            // Pemerintah: lihat semua conversation yang masuk ke dia
            $conversations = Conversation::with(['masyarakat', 'lastMessage'])
                ->where('pemerintah_id', $user->id)
                ->latest()
                ->get()
                ->map(fn ($c) => $this->format($c, $user));
        }

        return response()->json(['data' => $conversations]);
    }

    // GET /api/chat/{user} — buka atau buat conversation dengan user lain
    public function show(Request $request, User $user)
    {
        $auth = $request->user();

        // Validasi: tidak boleh chat dengan role yang sama
        if ($auth->role === $user->role) {
            return response()->json([
                'message' => 'Tidak bisa memulai percakapan dengan role yang sama.',
            ], 403);
        }

        // Tentukan siapa masyarakat dan siapa pemerintah
        $masyarakatId = $auth->role === 'masyarakat' ? $auth->id : $user->id;
        $pemerintahId = $auth->role === 'pemerintah' ? $auth->id : $user->id;

        // Cari atau buat conversation
        $conversation = Conversation::firstOrCreate([
            'masyarakat_id' => $masyarakatId,
            'pemerintah_id' => $pemerintahId,
        ]);

        $conversation->load(['masyarakat', 'pemerintah', 'lastMessage']);

        return response()->json([
            'data' => $this->format($conversation, $auth),
        ]);
    }

    // Format response
    private function format(Conversation $c, User $auth): array
    {
        $otherUser = $auth->role === 'masyarakat'
            ? $c->pemerintah
            : $c->masyarakat;

        $unread = $auth->role === 'pemerintah'
            ? $c->unreadMessagesForPemerintah()
            : $c->unreadMessagesForMasyarakat();

        return [
            'id'           => $c->id,
            'masyarakat_id'=> $c->masyarakat_id,
            'pemerintah_id'=> $c->pemerintah_id,
            'updated_at'   => $c->updated_at,
            'unread_count' => $unread,
            'other_user'   => $otherUser ? [
                'id'    => $otherUser->id,
                'name'  => $otherUser->name,
                'email' => $otherUser->email,
                'role'  => $otherUser->role,
            ] : null,
            'last_message' => $c->lastMessage ? [
                'id'         => $c->lastMessage->id,
                'sender_id'  => $c->lastMessage->sender_id,
                'message'    => $c->lastMessage->message,
                'created_at' => $c->lastMessage->created_at,
            ] : null,
        ];
    }
}
