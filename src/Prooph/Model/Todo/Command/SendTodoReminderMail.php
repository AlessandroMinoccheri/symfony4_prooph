<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Command;

use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use App\Prooph\Model\Todo\TodoId;
use App\Prooph\Model\User\UserId;

final class SendTodoReminderMail extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function with(UserId $userId, TodoId $todoId): SendTodoReminderMail
    {
        return new self([
            'user_id' => $userId->toString(),
            'todo_id' => $todoId->toString(),
        ]);
    }

    public function userId(): UserId
    {
        return UserId::fromString($this->payload['user_id']);
    }

    public function todoId(): TodoId
    {
        return TodoId::fromString($this->payload['todo_id']);
    }

    protected function setPayload(array $payload): void
    {
        Assertion::keyExists($payload, 'user_id');
        Assertion::uuid($payload['user_id']);
        Assertion::keyExists($payload, 'todo_id');
        Assertion::uuid($payload['todo_id']);

        $this->payload = $payload;
    }
}
