<?php

namespace App\Factory;

use App\Enum\Imageboard;
use DesuProject\ChanbooruInterface\ClientInterface;
use DesuProject\DanbooruSdk\Client as DanbooruClient;
use InvalidArgumentException;

class ImageboardClientFactory
{
    public static function create(Imageboard $imageboard): ClientInterface
    {
        switch ($imageboard->getValue()) {
            case Imageboard::DANBOORU:
                return new DanbooruClient(getenv('DANBOORU_API_KEY'));

            default:
                throw new InvalidArgumentException('Unknown imageboard');
        }
    }
}
