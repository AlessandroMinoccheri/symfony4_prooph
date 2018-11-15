<?php


declare(strict_types=1);

namespace App\Prooph\Infrastructure\Repository;

use App\Prooph\Model\Post\Post;
use App\Prooph\Model\Post\PostId;
use App\Prooph\Model\Post\PostList;
use Prooph\EventSourcing\Aggregate\AggregateRepository;

final class EventStorePostList extends AggregateRepository implements PostList
{
    public function save(Post $post): void
    {
        $this->saveAggregateRoot($post);
    }

    public function get(PostId $postId): ?Post
    {
        return $this->getAggregateRoot($postId->toString());
    }
}
