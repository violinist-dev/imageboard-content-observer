<?php

namespace App\ValueObject;

use App\Enum\ReportKeyboardAction;
use DesuProject\ChanbooruInterface\PostInterface;

class TelegramCallbackQuery
{
    /**
     * @var int
     */
    private $updateId;

    /**
     * @var string
     */
    private $callbackId;

    /**
     * @var int
     */
    private $chatId;

    /**
     * @var int
     */
    private $messageId;

    /**
     * @var string
     */
    private $username;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var PostInterface
     */
    private $imageboardPost;

    /**
     * @var ReportKeyboardAction
     */
    private $action;

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

    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    public function getCallbackId(): string
    {
        return $this->callbackId;
    }

    public function getChatId(): int
    {
        return $this->chatId;
    }

    public function getMessageId(): int
    {
        return $this->messageId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getImageboardPost(): PostInterface
    {
        return $this->imageboardPost;
    }

    public function getAction(): ReportKeyboardAction
    {
        return $this->action;
    }
}
