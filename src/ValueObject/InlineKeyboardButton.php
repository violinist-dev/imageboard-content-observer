<?php

namespace App\ValueObject;

use App\Enum\ReportKeyboardAction;
use DesuProject\ChanbooruInterface\PostInterface;

class InlineKeyboardButton
{
    /**
     * @var ReportKeyboardAction
     */
    private $action;

    /**
     * @var PostInterface
     */
    private $imageboardPost;

    /**
     * @var bool
     */
    private $isActive;

    /**
     * @var string
     */
    private $label;

    public function __construct(
        string $label,
        bool $isActive,
        ReportKeyboardAction $action,
        PostInterface $imageboardPost
    ) {
        $this->label = $label;
        $this->isActive = $isActive;
        $this->action = $action;
        $this->imageboardPost = $imageboardPost;
    }

    public function getAction(): ReportKeyboardAction
    {
        return $this->action;
    }

    public function getImageboardPost(): PostInterface
    {
        return $this->imageboardPost;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}
