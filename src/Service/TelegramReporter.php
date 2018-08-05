<?php

namespace App\Service;

use App\Factory\TelegramBotClientFactory;
use function App\getImageboardByPost;
use DesuProject\ChanbooruInterface\FileInterface;
use DesuProject\ChanbooruInterface\PostInterface;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

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
                    'mark_as_safe'
                ),
                $this->generateInlineButton(
                    'Explicit',
                    $post,
                    'mark_as_explicit'
                ),
            ],
            [
                $this->generateInlineButton(
                    'GIF',
                    $post,
                    'mark_as_gif'
                ),
                $this->generateInlineButton(
                    'Video',
                    $post,
                    'mark_as_video'
                ),
            ],
            [
                $this->generateInlineButton(
                    'Wallpaper',
                    $post,
                    'mark_as_wallpaper'
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
                'ac' => $action
            ])
        ];
    }
}
