<?php

namespace App\Command;

use App\Entity\Report;
use App\Factory\ImageboardClientFactory;
use App\Message\ReportPost;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use function App\getSupportedImageboards;

class ReportNewPostsCommand extends Command
{
    use LockableTrait;

    public const COMMAND = 'app:report-new-posts';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var ReportRepository
     */
    private $reportRepository;

    public function __construct(
        MessageBusInterface $messageBus,
        EntityManagerInterface $entityManager,
        ReportRepository $reportRepository
    ) {
        $this->messageBus = $messageBus;
        $this->entityManager = $entityManager;
        $this->reportRepository = $reportRepository;

        parent::__construct(self::COMMAND);
    }

    protected function configure(): void
    {
        $this->addArgument(
            'imageboard',
            InputArgument::REQUIRED,
            sprintf(
                'Imageboard name. One of: %s',
                implode(', ', getSupportedImageboards())
            )
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $output->writeln('<error>The command is already running in another process.</error>');

            return 1;
        }

        $client = ImageboardClientFactory::create($input->getArgument('imageboard'));

        foreach ($client->searchPosts([], 1, 20) as $post) {
            if ($post->isPostCensored()) {
                continue;
            }

            if ($this->reportRepository->isPostAlreadyReported($post)) {
                continue;
            }

            $this->messageBus->dispatch(new ReportPost($post));

            $report = new Report($post);
            $this->entityManager->persist($report);
        }

        $this->entityManager->flush();

        $this->release();

        return 0;
    }
}
