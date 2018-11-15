<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Exception;

use App\Prooph\Model\Todo\Todo;
use App\Prooph\Model\Todo\TodoDeadline;

final class TodoNotExpired extends \RuntimeException
{
    public static function withDeadline(TodoDeadline $deadline, Todo $todo): TodoNotExpired
    {
        return new self(sprintf(
            'Tried to mark a non-expired Todo as expired.  Todo will expire after the deadline %s.',
            $deadline->toString()
        ));
    }
}
