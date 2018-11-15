<?php


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

final class PostWasPosted extends AggregateChanged
{
    /**
     * @var TodoId
     */
    private $postId;

    private $text;

    private $description;

    private $writerId;

    private $status;

    public static function create(
        PostText $text,
        PostDescription $description,
        PostId $postId,
        UserId $writerId
    ): PostWasPosted {
        /** @var self $event */
        $event = self::occur($postId->toString(), [
            'text' => $text->toString(),
            'description' => $description->toString(),
            'writer_id' => $writerId->toString()
        ]);

        $event->postId = $postId;
        $event->text = $text;
        $event->description = $description;
        $event->writerId = $writerId;
        $event->status = PostStatus::DRAFT;

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

    public function writerId(): UserId
    {
        if (null === $this->writerId) {
            $this->writerId = UserId::fromString($this->payload['writer_id']);
        }

        return $this->writerId;
    }

    public function status() :PostStatus
    {
        return PostStatus::byName($this->status);
    }
}
