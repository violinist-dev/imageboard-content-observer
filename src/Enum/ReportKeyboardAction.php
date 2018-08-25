<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

class ReportKeyboardAction extends Enum
{
    const MARK_AS_SAFE = 'mark_as_safe';
    const MARK_AS_EXPLICIT = 'mark_as_explicit';
    const MARK_AS_GIF = 'mark_as_gif';
    const MARK_AS_VIDEO = 'mark_as_video';
    const MARK_AS_WALLPAPER = 'mark_as_wallpaper';
}
