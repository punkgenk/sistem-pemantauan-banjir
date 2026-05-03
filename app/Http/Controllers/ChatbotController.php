<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $apiKey = env('GROQ_API_KEY');

        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Kamu adalah asisten informasi banjir. Jawab dengan singkat dalam Bahasa Indonesia.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->message
                    ]
                ],
                'max_tokens' => 300,
            ]);

        \Log::info('Groq response: ' . json_encode($response->json()));

        $text = $response->json('choices.0.message.content') ?? 'Maaf, chatbot tidak dapat menjawab saat ini.';

        return response()->json(['reply' => $text]);
    }
}