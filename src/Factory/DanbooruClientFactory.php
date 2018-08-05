<?php

namespace App\Factory;

use DesuProject\DanbooruSdk\Client;

class DanbooruClientFactory
{
    public static function create(): Client
    {
        return new Client(
            base64_encode(getenv('DANBOORU_API_KEY')),
            false
        );
    }
}
