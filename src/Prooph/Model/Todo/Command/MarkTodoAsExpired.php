<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Command;

use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use App\Prooph\Model\Todo\TodoId;

final class MarkTodoAsExpired extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function forTodo(string $todoId): MarkTodoAsExpired
    {
        Assertion::uuid($todoId);

        return new self([
            'todo_id' => $todoId,
        ]);
    }

    public function todoId(): TodoId
    {
        return TodoId::fromString($this->payload['todo_id']);
    }
}
