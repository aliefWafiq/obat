<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $token;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
    }

    /**
     * Send a message via Fonnte WhatsApp/SMS API.
     */
    public function sendMessage(string $to, string $message): bool
    {
        if (setting('sistemWhatsapp', 'true') !== 'true') {
            Log::info('Sistem WhatsApp dinonaktifkan. Lewati pengiriman pesan.');
            return false;
        }

        if (empty($this->token)) {
            Log::warning('Fonnte token not set. Skipping sendMessage.');
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $to,
                'message' => $message,
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('Fonnte API error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Fonnte API exception: ' . $e->getMessage());
        }
        return false;
    }
}
?>
