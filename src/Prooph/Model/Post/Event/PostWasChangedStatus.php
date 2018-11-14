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

namespace App\Prooph\Model\Post\Event;

use App\Prooph\Model\Post\PostDescription;
use App\Prooph\Model\Post\PostId;
use App\Prooph\Model\Post\PostStatus;
use App\Prooph\Model\Post\PostText;
use Prooph\EventSourcing\AggregateChanged;
use App\Prooph\Model\Todo\TodoId;
use App\Prooph\Model\Todo\TodoStatus;
use App\Prooph\Model\Todo\TodoText;
use App\Prooph\Model\User\UserId;

final class PostWasChangedStatus extends AggregateChanged
{
    /**
     * @var TodoId
     */
    private $postId;

    private $status;

    public static function change(
        PostStatus $status,
        PostId $postId
    ): PostWasChangedStatus {
        /** @var self $event */
        $event = self::occur($postId->toString(), [
            'status' => $status->toString()
        ]);

        $event->postId = $postId;
        $event->status = $status->toString();

        return $event;
    }

    public function postId(): PostId
    {
        if (null === $this->postId) {
            $this->postId = PostId::fromString($this->aggregateId());
        }

        return $this->postId;
    }

    public function status(): PostStatus
    {
        return PostStatus::byName($this->payload['status']);
    }
}
