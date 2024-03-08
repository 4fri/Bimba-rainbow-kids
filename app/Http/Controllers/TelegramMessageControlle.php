<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class TelegramMessageControlle extends Controller
{
    public function sendMessage()
    {
        $api_tuban_prod_report = 'https://par4digma.sig.id/api/index.php/plant_tuban/tuban_prod_report';

        $data_tuban_prod_report = json_encode(file_get_contents($api_tuban_prod_report));

        $botToken = env('APP_BOT_TELEGRAM'); // Ganti dengan token bot Anda
        $chatId = env('TELEGRAM_CHAT_ID'); // Hapus spasi ekstra pada env('TELEGRAM_CHAT_ID')

        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

        $messageData = [
            'title' => 'Notification',
            'content' => 'Hello, this is a message from Laravel 10 with bot token',
        ];

        $messageText = "{$messageData['title']}\n\n{$messageData['content']}";

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $messageText,
        ]);

        // Periksa jika pengiriman pesan berhasil
        if ($response->successful()) {
            return response()->json(['status' => 'Pesan berhasil dikirim']);
        } else {
            return response()->json(['status' => 'Gagal mengirim pesan', 'error' => $response->status()]);
        }
    }
}
