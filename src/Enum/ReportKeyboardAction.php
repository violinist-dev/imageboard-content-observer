<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

class ReportKeyboardAction extends Enum
{
    public const MARK_AS_EXPLICIT = 'mark_as_explicit';
    public const MARK_AS_GIF = 'mark_as_gif';
    public const MARK_AS_SAFE = 'mark_as_safe';
    public const MARK_AS_VIDEO = 'mark_as_video';
    public const MARK_AS_WALLPAPER = 'mark_as_wallpaper';
}
