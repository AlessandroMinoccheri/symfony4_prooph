<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Exception;

use App\Prooph\Model\Todo\Todo;
use App\Prooph\Model\Todo\TodoStatus;

final class TodoAlreadyDone extends \RuntimeException
{
    public static function triedStatus(TodoStatus $status, Todo $todo): TodoAlreadyDone
    {
        return new self(sprintf(
            'Tried to change status of Todo %s to %s. But Todo is already marked as done!',
            $todo->todoId()->toString(),
            $status->toString()
        ));
    }
}
