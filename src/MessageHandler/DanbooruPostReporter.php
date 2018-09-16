<?php

namespace App\MessageHandler;

use App\Message\ReportPost;
use App\Service\TelegramReporter;
use DesuProject\DanbooruSdk\Client;
use DesuProject\DanbooruSdk\Post;

class DanbooruPostReporter
{
    /**
     * @var string
     */
    private $danbooruTelegramChatId;

    /**
     * @var TelegramReporter
     */
    private $telegramSender;

    public function __construct(
        TelegramReporter $telegramSender,
        string $danbooruTelegramChatId
    ) {
        $this->telegramSender = $telegramSender;
        $this->danbooruTelegramChatId = $danbooruTelegramChatId;
    }

    public function __invoke(ReportPost $message): void
    {
        $post = $message->getPost();

        if (!$post instanceof Post) {
            return;
        }

        $this->telegramSender->send(
            $this->danbooruTelegramChatId,
            $post,
            sprintf(
                '%s/posts/%d',
                Client::BASE_HOST,
                $post->getId()
            )
        );
    }
}
