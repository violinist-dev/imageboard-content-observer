<?php

namespace App\Message;

use DesuProject\ChanbooruInterface\PostInterface;

class ReportPost
{
    /**
     * @var PostInterface
     */
    private $post;

    public function __construct(PostInterface $post)
    {
        $this->post = $post;
    }

    public function getPost(): PostInterface
    {
        return $this->post;
    }
}
