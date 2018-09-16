<?php

namespace App\ValueObject;

use App\Enum\ReportKeyboardAction;
use DesuProject\ChanbooruInterface\PostInterface;

class TelegramCallbackQuery
{
    /**
     * @var ReportKeyboardAction
     */
    private $action;

    /**
     * @var string
     */
    private $callbackId;

    /**
     * @var int
     */
    private $chatId;

    /**
     * @var PostInterface
     */
    private $imageboardPost;

    /**
     * @var int
     */
    private $messageId;

    /**
     * @var int
     */
    private $updateId;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $username;

    public function __construct(
        int $updateId,
        string $callbackId,
        int $chatId,
        int $messageId,
        string $username,
        int $userId,
        PostInterface $imageboardPost,
        ReportKeyboardAction $action
    ) {
        $this->updateId = $updateId;
        $this->callbackId = $callbackId;
        $this->chatId = $chatId;
        $this->messageId = $messageId;
        $this->username = $username;
        $this->userId = $userId;
        $this->imageboardPost = $imageboardPost;
        $this->action = $action;
    }

    public function getAction(): ReportKeyboardAction
    {
        return $this->action;
    }

    public function getCallbackId(): string
    {
        return $this->callbackId;
    }

    public function getChatId(): int
    {
        return $this->chatId;
    }

    public function getImageboardPost(): PostInterface
    {
        return $this->imageboardPost;
    }

    public function getMessageId(): int
    {
        return $this->messageId;
    }

    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
