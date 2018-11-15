<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Command;

use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use App\Prooph\Model\Todo\TodoId;
use App\Prooph\Model\Todo\TodoReminder;
use App\Prooph\Model\Todo\TodoReminderStatus;

final class RemindTodoAssignee extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function forTodo(TodoId $todoId, TodoReminder $todoReminder): RemindTodoAssignee
    {
        return new self([
            'todo_id' => $todoId->toString(),
            'reminder' => $todoReminder->toString(),
            'reminder_status' => $todoReminder->status()->toString(),
        ]);
    }

    public function todoId(): TodoId
    {
        return TodoId::fromString($this->payload['todo_id']);
    }

    public function reminder(): TodoReminder
    {
        return TodoReminder::from($this->payload['reminder'], $this->payload['reminder_status']);
    }

    protected function setPayload(array $payload): void
    {
        Assertion::keyExists($payload, 'todo_id');
        Assertion::uuid($payload['todo_id']);
        Assertion::keyExists($payload, 'reminder');
        Assertion::string($payload['reminder']); // @todo: check for date format
        Assertion::keyExists($payload, 'reminder_status');
        Assertion::true(defined(TodoReminderStatus::class . '::' . $payload['reminder_status']));

        $this->payload = $payload;
    }
}
