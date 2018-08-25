<?php

namespace App\Action;

use App\Factory\TelegramBotClientFactory;
use App\Service\TelegramReporter;
use App\ValueObject\TelegramCallbackQuery;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\ChatMember;

class TelegramWebhookAction
{
    const ROUTE_NAME = 'telegram_webhook';

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var TelegramReporter
     */
    private $telegramReporter;

    /**
     * @var string
     */
    private $telegramWebhookSecret;

    public function __construct(
        RequestStack $requestStack,
        LoggerInterface $logger,
        SerializerInterface $serializer,
        TelegramReporter $telegramReporter,
        string $telegramWebhookSecret
    ) {
        $this->requestStack = $requestStack;
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->telegramReporter = $telegramReporter;
        $this->telegramWebhookSecret = $telegramWebhookSecret;
    }

    /**
     * @Route(
     *     "/telegram-webhook",
     *     name=TelegramWebhookAction::ROUTE_NAME,
     *     methods={Request::METHOD_POST}
     * )
     */
    public function __invoke(): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $telegramClient = TelegramBotClientFactory::create();

        $this->logger->info(
            'Telegram webhook triggered',
            [
                'url' => $request->getUri(),
                'headers' => $request->headers,
                'content' => $request->getContent(),
                'ip' => $request->getClientIp(),
            ]
        );

        $callbackQuery = $this->serializeCallbackQuery($request);

        if ($this->isWebhookAccessTokenValid($request)) {
            $telegramClient->answerCallbackQuery(
                $callbackQuery->getCallbackId(),
                'Webhook access token is incorrect.',
                true
            );

            return new Response(
                'Webhook access token is incorrect.',
                Response::HTTP_FORBIDDEN
            );
        }

        if ($this->isTelegramUserAllowedToManageContent(
            $telegramClient,
            $callbackQuery
        ) === false) {
            $this->logger->warning(
                'Telegram webhook triggered by unauthorized user',
                [
                    'url' => $request->getUri(),
                    'headers' => $request->headers,
                    'content' => $request->getContent(),
                    'ip' => $request->getClientIp(),
                ]
            );

            $telegramClient->answerCallbackQuery(
                $callbackQuery->getCallbackId(),
                'Only channel administrators can manage content.',
                true
            );

            return new Response(
                'Only channel administrators can manage content.',
                Response::HTTP_NO_CONTENT
            );
        }

        $this->telegramReporter->editInlineKeyboardButtons(
            $callbackQuery->getChatId(),
            $callbackQuery->getMessageId(),
            $callbackQuery->getImageboardPost(),
            [
                $callbackQuery->getAction(),
            ]
        );

        return new Response(
            '',
            Response::HTTP_NO_CONTENT
        );
    }

    private function serializeCallbackQuery(Request $request): TelegramCallbackQuery
    {
        $payload = $request->getContent();

        if (0 === mb_strlen($payload)) {
            throw new BadRequestHttpException('JSON expected.');
        }

        /**
         * @var TelegramCallbackQuery
         */
        $telegramCallbackQuery = $this->serializer->deserialize(
            $payload,
            TelegramCallbackQuery::class,
            JsonEncoder::FORMAT
        );

        return $telegramCallbackQuery;
    }

    private function isTelegramUserAllowedToManageContent(
        BotApi $telegramClient,
        TelegramCallbackQuery $callbackQuery
    ): bool {
        /**
         * @var ChatMember[]
         */
        $admins = $telegramClient->getChatAdministrators($callbackQuery->getChatId());

        foreach ($admins as $admin) {
            if ($admin->getUser()->getId() === $callbackQuery->getUserId()) {
                return true;
            }
        }

        return false;
    }

    private function isWebhookAccessTokenValid(Request $request): bool
    {
        return $request->get('webhookAccessToken') !== $this->telegramWebhookSecret;
    }
}
