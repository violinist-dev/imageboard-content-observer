<?php

namespace App\Command;

use App\Entity\Report;
use App\Factory\DanbooruClientFactory;
use function App\getSupportedImageboards;
use const App\IMAGEBOARD_DANBOORU;
use App\Message\ReportPost;
use App\Repository\ReportRepository;
use DesuProject\DanbooruSdk\Post;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Messenger\MessageBusInterface;

class ReportNewPostsCommand extends Command
{
    use LockableTrait;

    const COMMAND = 'app:report-new-posts';

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

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

    protected function configure()
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

        switch ($input->getArgument('imageboard')) {
            case IMAGEBOARD_DANBOORU:
                $client = DanbooruClientFactory::create();
                $posts = Post::search($client, [], 1, 20);

                break;

            default:
                throw new RuntimeException('Unknown imageboard type');
        }

        foreach ($posts as $post) {
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
