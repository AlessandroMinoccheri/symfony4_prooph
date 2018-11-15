<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Exception;

use App\Prooph\Model\Todo\Todo;

final class CannotReopenTodo extends \RuntimeException
{
    public static function notMarkedDone(Todo $todo): CannotReopenTodo
    {
        return new self(sprintf(
            'Tried to reopen status of Todo %s. But Todo is not marked as done!',
            $todo->todoId()->toString()
        ));
    }
}
