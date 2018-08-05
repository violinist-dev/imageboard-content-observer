<?php

namespace App\Factory;

use TelegramBot\Api\BotApi;

class TelegramBotClientFactory
{
    public static function create(): BotApi
    {
        $client = new BotApi(
            getenv('TELEGRAM_BOT_API_KEY')
        );

        $client->setCurlOption(CURLOPT_HTTPHEADER, ['Expect:']);

        return $client;
    }
}
