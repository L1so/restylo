<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIService
{
    /**
     * Send a prompt to Google Gemini (Generative Language API) and return text output.
     *
     * @param string $prompt
     * @param int $maxTokens
     * @param float $temperature
     * @return string
     */
    public function generate(string $prompt, int $maxTokens = 256, float $temperature = 0.7): string
    {
        $key = config('services.gemini.key') ?: env('GEMINI_API_KEY');
        if (empty($key)) {
            throw new \RuntimeException('GEMINI_API_KEY not set in config/services.php or .env');
        }

        $url = 'https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent?key=' . urlencode($key);

        // Correct payload format for Gemini API v1
        $body = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'maxOutputTokens' => $maxTokens,
                'temperature' => $temperature,
            ]
        ];

        $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($url, $body);

        if (! $response->successful()) {
            throw new \RuntimeException('Gemini API request failed: ' . $response->body());
        }

        $json = $response->json();

        // Extract generated text from the correct response structure
        if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
            return (string) $json['candidates'][0]['content']['parts'][0]['text'];
        }

        // Check if there are parts in the content
        if (isset($json['candidates'][0]['content']['parts']) && is_array($json['candidates'][0]['content']['parts'])) {
            $textParts = [];
            foreach ($json['candidates'][0]['content']['parts'] as $part) {
                if (isset($part['text'])) {
                    $textParts[] = $part['text'];
                }
            }
            if (!empty($textParts)) {
                return implode("\n", $textParts);
            }
        }

        // Fallback for any other response structure
        if (isset($json['candidates'][0]['output'])) {
            return (string) $json['candidates'][0]['output'];
        }

        // Check if the response was cut off due to max tokens
        if (isset($json['candidates'][0]['finishReason']) && $json['candidates'][0]['finishReason'] === 'MAX_TOKENS') {
            throw new \RuntimeException('Response was truncated due to max tokens limit. Try reducing the prompt or increasing maxOutputTokens.');
        }

        // If we can't find the text, throw an error with the response
        throw new \RuntimeException('Unexpected Gemini API response structure: ' . json_encode($json));
    }
}
