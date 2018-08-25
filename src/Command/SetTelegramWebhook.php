<?php

namespace App\Command;

use App\Action\TelegramWebhookAction;
use App\Factory\TelegramBotClientFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\RouterInterface;

class SetTelegramWebhook extends Command
{
    use LockableTrait;

    const COMMAND = 'app:set-telegram-webhook';

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $telegramWebhookSecret;

    public function __construct(
        RouterInterface $router,
        string $telegramWebhookSecret
    ) {
        $this->router = $router;
        $this->telegramWebhookSecret = $telegramWebhookSecret;

        parent::__construct(self::COMMAND);
    }

    protected function configure()
    {
        $this->addArgument(
            'host',
            InputArgument::REQUIRED,
            'Host name. E.g. "40e66d47.ngrok.io".'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $output->writeln('<error>The command is already running in another process.</error>');

            return 1;
        }

        $webhookPath = $this->router->generate(
            TelegramWebhookAction::ROUTE_NAME,
            [
                'webhookAccessToken' => $this->telegramWebhookSecret,
            ]
        );
        $webhookUrl = sprintf(
            'https://%s%s',
            $input->getArgument('host'),
            $webhookPath
        );

        $client = TelegramBotClientFactory::create();
        $client->setWebhook($webhookUrl);

        $output->writeln(sprintf(
            'Webhook set to this URL: %s',
            $webhookUrl
        ));

        $this->release();

        return 0;
    }
}
