<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Command;

use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use App\Prooph\Model\Todo\TodoId;

final class MarkTodoAsDone extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function with(string $todoId): MarkTodoAsDone
    {
        return new self([
            'todo_id' => $todoId,
        ]);
    }

    public function todoId(): TodoId
    {
        return TodoId::fromString($this->payload['todo_id']);
    }

    protected function setPayload(array $payload): void
    {
        Assertion::keyExists($payload, 'todo_id');
        Assertion::uuid($payload['todo_id']);

        $this->payload = $payload;
    }
}
