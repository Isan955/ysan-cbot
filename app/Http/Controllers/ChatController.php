<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::where('user_id', Auth::id())->get();
        return view('chat', compact('chats'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->input('message');

        Chat::create([
            'user_id' => Auth::id(),
            'role' => 'user',
            'message' => $userMessage,
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'openai/gpt-3.5-turbo', // model yang stabil
                'messages' => [
                    ['role' => 'system', 'content' => 'Anda adalah asisten yang ramah dan membantu.'],
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);

            $replyData = $response->json();

            $replyText = trim($replyData['choices'][0]['message']['content'] ?? '');

            $replyText = preg_replace('/<\/?s>/', '', $replyText);   // hapus <s> </s>
            $replyText = preg_replace('/\[\/?s\]/', '', $replyText); // hapus [s] [/s]
            $replyText = preg_replace('/~~(.*?)~~/', '$1', $replyText); // hapus strikethrough
            $replyText = str_replace(['*', '#', '_', '`'], '', $replyText); // hapus simbol markdown lain

            if ($replyText === '' || strtolower($replyText) === 's') {
                $replyText = "⚠️ Maaf, saya belum bisa menemukan jawaban untuk pertanyaan ini.";
            }

        } catch (\Exception $e) {
            $replyText = "⚠️ Terjadi kesalahan: " . $e->getMessage();
        }

        Chat::create([
            'user_id' => Auth::id(),
            'role' => 'bot',
            'message' => $replyText,
        ]);

        return response()->json(['reply' => $replyText]);
    }
}
