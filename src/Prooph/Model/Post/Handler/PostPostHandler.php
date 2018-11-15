<?php


declare(strict_types=1);

namespace App\Prooph\Model\Post\Handler;

use App\Prooph\Model\Post\Command\PostPost;
use App\Prooph\Model\Post\Post;
use App\Prooph\Model\Post\PostList;

class PostPostHandler
{
    /**
     * @var PostList
     */
    private $postList;

    public function __construct(PostList $postList)
    {
        $this->postList = $postList;
    }


    public function __invoke(PostPost $command): void
    {
        $post = Post::post($command->text(), $command->description(), $command->postId(), $command->writerId());

        $this->postList->save($post);
    }
}
