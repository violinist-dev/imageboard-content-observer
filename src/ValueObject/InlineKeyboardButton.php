<?php

namespace App\ValueObject;

use App\Enum\ReportKeyboardAction;
use DesuProject\ChanbooruInterface\PostInterface;

class InlineKeyboardButton
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var bool
     */
    private $isActive;

    /**
     * @var ReportKeyboardAction
     */
    private $action;

    /**
     * @var PostInterface
     */
    private $imageboardPost;

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

    public function getLabel(): string
    {
        return $this->label;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getAction(): ReportKeyboardAction
    {
        return $this->action;
    }

    public function getImageboardPost(): PostInterface
    {
        return $this->imageboardPost;
    }
}