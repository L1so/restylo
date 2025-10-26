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
    public function generate(string $prompt, int $maxTokens = 256, float $temperature = 0.2): string
    {
        $key = config('services.gemini.key') ?: env('GEMINI_API_KEY');
        if (empty($key)) {
            throw new \RuntimeException('GEMINI_API_KEY not set in config/services.php or .env');
        }

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . urlencode($key);

        // Try the `input.text` payload shape first (common for Generative Language API)
        $body = [
            'input' => ['text' => $prompt],
            'maxOutputTokens' => $maxTokens,
            'temperature' => $temperature,
        ];

        $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($url, $body);

        // If the API returns an invalid-argument about unknown fields, try an alternate payload shape
        if (! $response->successful()) {
            $jsonBody = $response->json();
            $message = $response->body();
            // If response indicates unknown fields, try older/alternate payload
            if (is_array($jsonBody) && isset($jsonBody['error']['details'])) {
                // try alternate payload that some endpoints accept
                $altBody = [
                    'prompt' => ['text' => $prompt],
                    'maxOutputTokens' => $maxTokens,
                    'temperature' => $temperature,
                ];
                $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($url, $altBody);
            }
        }

        if (! $response->successful()) {
            throw new \RuntimeException('Gemini API request failed: ' . $response->body());
        }

        $json = $response->json();

        // Try common locations for generated text depending on response shape
        if (isset($json['candidates'][0]['output'])) {
            return (string) $json['candidates'][0]['output'];
        }

        if (isset($json['candidates'][0]['content']) && is_array($json['candidates'][0]['content'])) {
            $parts = [];
            foreach ($json['candidates'][0]['content'] as $c) {
                if (is_string($c)) {
                    $parts[] = $c;
                } elseif (isset($c['text'])) {
                    $parts[] = $c['text'];
                }
            }
            if (! empty($parts)) {
                return implode("\n", $parts);
            }
        }

        // Last-resort: return whole JSON as string
        return is_string($response->body()) ? $response->body() : json_encode($json);
    }
}
