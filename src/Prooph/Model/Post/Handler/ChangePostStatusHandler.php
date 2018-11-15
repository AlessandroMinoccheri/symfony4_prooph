<?php


declare(strict_types=1);

namespace App\Prooph\Model\Post\Handler;

use App\Prooph\Model\Post\Command\ChangePostStatus;
use App\Prooph\Model\Post\PostList;

class ChangePostStatusHandler
{
    /**
     * @var PostList
     */
    private $postList;

    public function __construct(PostList $postList)
    {
        $this->postList = $postList;
    }

    public function __invoke(ChangePostStatus $command): void
    {
        $post = $this->postList->get($command->postId());
        $post->changeStatus($command->status());

        $this->postList->save($post);
    }
}


