<?php


declare(strict_types=1);

namespace App\Prooph\Model\Post;


interface PostList
{
    public function save(Post $post): void;

    public function get(PostId $postId): ?Post;
}
