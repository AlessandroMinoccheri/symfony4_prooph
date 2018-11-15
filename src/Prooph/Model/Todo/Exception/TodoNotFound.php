<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Exception;

use App\Prooph\Model\Todo\TodoId;

final class TodoNotFound extends \InvalidArgumentException
{
    public static function withTodoId(TodoId $todoId): TodoNotFound
    {
        return new self(sprintf('Todo with id %s cannot be found.', $todoId->toString()));
    }
}
