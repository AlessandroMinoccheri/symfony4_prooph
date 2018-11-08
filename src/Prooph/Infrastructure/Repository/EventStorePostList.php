<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2017 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2017 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
