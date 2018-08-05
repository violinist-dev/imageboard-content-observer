<?php

namespace App\Repository;

use App\Entity\Report;
use DesuProject\ChanbooruInterface\PostInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use function App\getImageboardByPost;

class ReportRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Report::class);
    }

    public function isPostAlreadyReported(
        PostInterface $post
    ): bool {
        $qb = $this->createQueryBuilder('report');

        $qb->where('report.post = :post');
        $qb->setParameter('post', json_encode([
            'id' => $post->getId(),
            'imageboard' => getImageboardByPost($post),
        ]));

        return count($qb->getQuery()->execute()) !== 0;
    }
}
