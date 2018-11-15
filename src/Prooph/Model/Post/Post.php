<?php


declare(strict_types=1);

namespace App\Prooph\Model\Post;

use App\Prooph\Model\Post\Event\PostWasChangedStatus;
use App\Prooph\Model\Post\Event\PostWasPosted;
use App\Prooph\Model\User\UserId;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use App\Prooph\Model\Entity;

final class Post extends AggregateRoot implements Entity
{
    /**
     * @var PostId
     */
    private $postId;

    /**
     * @var PostText
     */
    private $text;

    /**
     * @var PostDescription
     */
    private $description;

    /**
     * @var UserId
     */
    private $writerId;

    /**
     * @var PostStatus
     */
    private $status;

    public static function post(PostText $text, PostDescription $description, PostId $postId, UserId $writerId): Post
    {
        $self = new self();
        $self->recordThat(PostWasPosted::create($text, $description, $postId, $writerId));

        return $self;
    }

    public function changeStatus(PostStatus $status): void
    {
        $this->recordThat(PostWasChangedStatus::change($status, $this->postId));
    }

    public function postId(): PostId
    {
        return $this->postId;
    }

    public function text(): PostText
    {
        return $this->text;
    }

    public function description(): PostDescription
    {
        return $this->description;
    }

    public function writerId(): UserId
    {
        return $this->writerId;
    }

    protected function whenPostWasPosted(PostWasPosted $event): void
    {
        $this->postId = $event->postId();
        $this->text = $event->text();
        $this->description = $event->description();
        $this->writerId = $event->writerId();
    }

    protected function whenPostWasChangedStatus(PostWasChangedStatus $event): void
    {
        $this->postId = $event->postId();
        $this->status = $event->status();
    }

    protected function aggregateId(): string
    {
        return $this->postId->toString();
    }

    public function sameIdentityAs(Entity $other): bool
    {
        return get_class($this) === get_class($other) && $this->postId->sameValueAs($other->postId);
    }

    /**
     * Apply given event
     */
    protected function apply(AggregateChanged $e): void
    {
        $handler = $this->determineEventHandlerMethodFor($e);

        if (! method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                get_class($this)
            ));
        }

        $this->{$handler}($e);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $e): string
    {
        return 'when' . implode(array_slice(explode('\\', get_class($e)), -1));
    }
}
