<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use DateTimeImmutable;
use DesuProject\ChanbooruInterface\PostInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 */
class Report
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     *
     * @var UuidInterface
     */
    private $id;

    /**
     * @ORM\Column(type="imageboard_post", unique=true)
     *
     * @var PostInterface
     */
    private $post;

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @var DateTimeImmutable
     */
    private $reportedAt;

    public function __construct(
        PostInterface $post
    ) {
        $this->id = Uuid::uuid4();
        $this->post = $post;
        $this->reportedAt = new DateTimeImmutable();
    }
}
