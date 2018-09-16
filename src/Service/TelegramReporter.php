<?php

namespace App\Service;

use App\Enum\ReportKeyboardAction;
use App\Factory\TelegramBotClientFactory;
use App\ValueObject\InlineKeyboardButton;
use DesuProject\ChanbooruInterface\FileInterface;
use DesuProject\ChanbooruInterface\PostInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class TelegramReporter
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     * @param string                 $chatId
     * @param int                    $messageId
     * @param PostInterface          $post
     * @param ReportKeyboardAction[] $activeButtonActions
     */
    public function editInlineKeyboardButtons(
        string $chatId,
        int $messageId,
        PostInterface $post,
        array $activeButtonActions
    ): void {
        $client = TelegramBotClientFactory::create();

        $client->editMessageReplyMarkup(
            $chatId,
            $messageId,
            $this->generateKeyboard($post, $activeButtonActions)
        );
    }

    public function send(
        string $chatId,
        PostInterface $post,
        string $postUrl
    ): void {
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

        $inlineKeyboard = $this->generateKeyboard($post, []);

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

    private function generateKeyboard(
        PostInterface $post,
        array $activeButtonActions
    ): InlineKeyboardMarkup {
        $keyboard = [];

        $keyboard[0][] = new InlineKeyboardButton(
            'Safe',
            $this->shouldButtonBeActive(
                $activeButtonActions,
                new ReportKeyboardAction(ReportKeyboardAction::MARK_AS_SAFE)
            ),
            new ReportKeyboardAction(ReportKeyboardAction::MARK_AS_SAFE),
            $post
        );

        $keyboard[0][] = new InlineKeyboardButton(
            'Explicit',
            $this->shouldButtonBeActive(
                $activeButtonActions,
                new ReportKeyboardAction(ReportKeyboardAction::MARK_AS_EXPLICIT)
            ),
            new ReportKeyboardAction(ReportKeyboardAction::MARK_AS_EXPLICIT),
            $post
        );

        $keyboard[1][] = new InlineKeyboardButton(
            'GIF',
            $this->shouldButtonBeActive(
                $activeButtonActions,
                new ReportKeyboardAction(ReportKeyboardAction::MARK_AS_GIF)
            ),
            new ReportKeyboardAction(ReportKeyboardAction::MARK_AS_GIF),
            $post
        );

        $keyboard[1][] = new InlineKeyboardButton(
            'Video',
            $this->shouldButtonBeActive(
                $activeButtonActions,
                new ReportKeyboardAction(ReportKeyboardAction::MARK_AS_VIDEO)
            ),
            new ReportKeyboardAction(ReportKeyboardAction::MARK_AS_VIDEO),
            $post
        );

        $keyboard[2][] = new InlineKeyboardButton(
            'Wallpaper',
            $this->shouldButtonBeActive(
                $activeButtonActions,
                new ReportKeyboardAction(ReportKeyboardAction::MARK_AS_WALLPAPER)
            ),
            new ReportKeyboardAction(ReportKeyboardAction::MARK_AS_WALLPAPER),
            $post
        );

        $keyboardButtons = $this->serializer->serialize($keyboard, JsonEncoder::FORMAT);

        /**
         * @var InlineKeyboardMarkup
         */
        $keyboard = $this->serializer->deserialize(
            $keyboardButtons,
            InlineKeyboardMarkup::class,
            JsonEncoder::FORMAT
        );

        return $keyboard;
    }

    /**
     * @param ReportKeyboardAction[] $activeButtonActions
     * @param ReportKeyboardAction   $action
     */
    private function shouldButtonBeActive(
        array $activeButtonActions,
        ReportKeyboardAction $action
    ): bool {
        foreach ($activeButtonActions as $activeButtonAction) {
            if ($action->equals($activeButtonAction) === true) {
                return true;
            }
        }

        return false;
    }
}
