<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        try {
    
            $message = $request->message;
    
            $response = Http::post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
                [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' =>
                                    "Kamu adalah Asisten Kampus KAMPUS/presence.
    
                                    Jawab dalam Bahasa Indonesia yang ramah.
    
                                    Pertanyaan:
                                    {$message}"
                                ]
                            ]
                        ]
                    ]
                ]
            );
    
            if (!$response->successful()) {
    
                return response()->json([
                    'reply' => 'Error Gemini: ' . $response->body()
                ]);
            }
    
            $reply =
                $response->json()['candidates'][0]['content']['parts'][0]['text']
                ?? 'Maaf, saya tidak dapat menjawab saat ini.';
    
            return response()->json([
                'reply' => $reply
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'reply' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}