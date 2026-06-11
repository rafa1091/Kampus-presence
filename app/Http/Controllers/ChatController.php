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
            $history = $request->history ?? [];

            $contents = [];

            // System Prompt
            $contents[] = [
                'role' => 'user',
                'parts' => [
                    [
                        'text' => 'Kamu adalah Asisten Kampus KAMPUS/presence. Jawab dalam Bahasa Indonesia yang ramah dan singkat.'
                    ]
                ]
            ];

            foreach ($history as $item) {
                $contents[] = [
                    'role' => $item['role'],
                    'parts' => [
                        [
                            'text' => $item['text']
                        ]
                    ]
                ];
            }

            $contents[] = [
                'role' => 'user',
                'parts' => [
                    [
                        'text' => $message
                    ]
                ]
            ];

            $response = Http::timeout(30)->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
                [
                    'contents' => $contents
                ]
            );

            if (!$response->successful()) {
                return response()->json([
                    'reply' => 'Maaf, server AI sedang bermasalah.'
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
                'reply' => 'Maaf, terjadi kesalahan pada server.'
            ]);
        }
    }
}