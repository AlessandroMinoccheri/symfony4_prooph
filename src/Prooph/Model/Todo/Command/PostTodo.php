<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Command;

use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use App\Prooph\Model\Todo\TodoId;
use App\Prooph\Model\Todo\TodoText;
use App\Prooph\Model\User\UserId;

final class PostTodo extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function forUser(string $assigneeId, string $text, string $todoId): PostTodo
    {
        return new self([
            'assignee_id' => $assigneeId,
            'todo_id' => $todoId,
            'text' => $text,
        ]);
    }

    public function todoId(): TodoId
    {
        return TodoId::fromString($this->payload['todo_id']);
    }

    public function assigneeId(): UserId
    {
        return UserId::fromString($this->payload['assignee_id']);
    }

    public function text(): TodoText
    {
        return TodoText::fromString($this->payload['text']);
    }

    protected function setPayload(array $payload): void
    {
        Assertion::keyExists($payload, 'assignee_id');
        Assertion::uuid($payload['assignee_id']);
        Assertion::keyExists($payload, 'todo_id');
        Assertion::uuid($payload['todo_id']);
        Assertion::keyExists($payload, 'text');
        Assertion::string($payload['text']);

        $this->payload = $payload;
    }
}
