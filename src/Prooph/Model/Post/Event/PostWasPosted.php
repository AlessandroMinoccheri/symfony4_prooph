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
use App\Prooph\Model\Post\PostText;
use Prooph\EventSourcing\AggregateChanged;
use App\Prooph\Model\Todo\TodoId;
use App\Prooph\Model\Todo\TodoStatus;
use App\Prooph\Model\Todo\TodoText;
use App\Prooph\Model\User\UserId;

final class PostWasPosted extends AggregateChanged
{
    /**
     * @var TodoId
     */
    private $postId;

    private $text;

    private $description;

    public static function create(PostText $text, PostDescription $description, PostId $postId): PostWasPosted
    {
        /** @var self $event */
        $event = self::occur($postId->toString(), [
            'text' => $text->toString(),
            'description' => $description->toString(),
        ]);

        $event->postId = $postId;
        $event->text = $text;
        $event->description = $description;

        return $event;
    }

    public function postId(): PostId
    {
        if (null === $this->postId) {
            $this->postId = PostId::fromString($this->aggregateId());
        }

        return $this->postId;
    }

    public function text(): PostText
    {
        return PostText::fromString($this->payload['text']);
    }

    public function description(): PostDescription
    {
        return PostDescription::fromString($this->payload['description']);
    }
}
