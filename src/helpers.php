<?php

namespace App;

use DesuProject\ChanbooruInterface\PostInterface;
use DesuProject\DanbooruSdk;
use RuntimeException;

function getImageboardByPost(PostInterface $post): string
{
    switch (true) {
        case $post instanceof DanbooruSdk\Post:
            return IMAGEBOARD_DANBOORU;

        default:
            throw new RuntimeException('Unknown imageboard type');
    }
}

/**
 * @return string[]
 */
function getSupportedImageboards(): array
{
    return [
        IMAGEBOARD_DANBOORU,
    ];
}
