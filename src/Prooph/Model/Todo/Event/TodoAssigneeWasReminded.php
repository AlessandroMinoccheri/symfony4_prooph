<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Event;

use Prooph\EventSourcing\AggregateChanged;
use App\Prooph\Model\Todo\TodoId;
use App\Prooph\Model\Todo\TodoReminder;
use App\Prooph\Model\User\UserId;

final class TodoAssigneeWasReminded extends AggregateChanged
{
    /**
     * @var TodoId
     */
    private $todoId;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var TodoReminder
     */
    private $reminder;

    public static function forAssignee(TodoId $todoId, UserId $userId, TodoReminder $reminder): TodoAssigneeWasReminded
    {
        /** @var self $event */
        $event = self::occur($todoId->toString(), [
            'user_id' => $userId->toString(),
            'reminder' => $reminder->toString(),
            'reminder_status' => $reminder->status()->toString(),
        ]);

        $event->userId = $userId;
        $event->reminder = $reminder;

        return $event;
    }

    public function todoId(): TodoId
    {
        if (! $this->todoId) {
            $this->todoId = TodoId::fromString($this->aggregateId());
        }

        return $this->todoId;
    }

    public function userId(): UserId
    {
        if (! $this->userId) {
            $this->userId = UserId::fromString($this->payload['user_id']);
        }

        return $this->userId;
    }

    public function reminder(): TodoReminder
    {
        if (! $this->reminder) {
            $this->reminder = TodoReminder::from($this->payload['reminder'], $this->payload['reminder_status']);
        }

        return $this->reminder;
    }
}
