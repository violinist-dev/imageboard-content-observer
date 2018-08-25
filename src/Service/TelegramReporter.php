<?php

namespace App\Service;

use App\Enum\ReportKeyboardAction;
use App\Factory\TelegramBotClientFactory;
use DesuProject\ChanbooruInterface\FileInterface;
use DesuProject\ChanbooruInterface\PostInterface;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use function App\getImageboardByPost;

class TelegramReporter
{
    public function send(
        string $chatId,
        PostInterface $post,
        string $postUrl
    ) {
        $client = TelegramBotClientFactory::create();

        $captionTemplate = 'Post <a href="%1$s">%2$d</a>' . "\n\n"
            . '• Resolution: %3$d×%4$d';

        $caption = sprintf(
            $captionTemplate,
            $postUrl,
            $post->getId(),
            $post->getSourceFile()->getWidth(),
            $post->getSourceFile()->getHeight()
        );

        $inlineKeyboard = new InlineKeyboardMarkup([
            [
                $this->generateInlineButton(
                    'Safe',
                    $post,
                    ReportKeyboardAction::MARK_AS_SAFE
                ),
                $this->generateInlineButton(
                    'Explicit',
                    $post,
                    ReportKeyboardAction::MARK_AS_EXPLICIT
                ),
            ],
            [
                $this->generateInlineButton(
                    'GIF',
                    $post,
                    ReportKeyboardAction::MARK_AS_GIF
                ),
                $this->generateInlineButton(
                    'Video',
                    $post,
                    ReportKeyboardAction::MARK_AS_VIDEO
                ),
            ],
            [
                $this->generateInlineButton(
                    'Wallpaper',
                    $post,
                    ReportKeyboardAction::MARK_AS_WALLPAPER
                ),
            ],
        ]);

        switch ($post->getSourceFile()->getType()) {
            case FileInterface::TYPE_IMAGE:
                $client->sendPhoto(
                    $chatId,
                    $post->getSourceFile()->getUrl(),
                    $caption,
                    null,
                    $inlineKeyboard,
                    false,
                    'HTML'
                );

                break;

            case FileInterface::TYPE_VIDEO:
                $client->sendVideo(
                    $chatId,
                    $post->getSourceFile()->getUrl(),
                    null,
                    $caption,
                    null,
                    $inlineKeyboard,
                    false,
                    false,
                    'HTML'
                );

                break;

            default:
                $client->sendDocument(
                    $chatId,
                    $post->getSourceFile()->getUrl(),
                    $caption,
                    null,
                    $inlineKeyboard,
                    false,
                    'HTML'
                );

                break;
        }
    }

    private function generateInlineButton(
        string $label,
        PostInterface $post,
        string $action
    ): array {
        return [
            'text' => $label,
            'callback_data' => json_encode([
                'ib' => getImageboardByPost($post),
                'pi' => $post->getId(),
                'ac' => $action,
            ]),
        ];
    }
}
