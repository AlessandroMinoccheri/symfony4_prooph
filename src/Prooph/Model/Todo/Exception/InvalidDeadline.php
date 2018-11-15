<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Exception;

use App\Prooph\Model\Todo\TodoDeadline;
use App\Prooph\Model\User\UserId;

final class InvalidDeadline extends \Exception
{
    public static function userIsNotAssignee(UserId $user, UserId $assigneeId): InvalidDeadline
    {
        return new self(sprintf(
            'User %s tried to add a deadline to the todo owned by %s',
            $user->toString(),
            $assigneeId->toString()
        ));
    }

    public static function deadlineInThePast(TodoDeadline $deadline): InvalidDeadline
    {
        return new self(sprintf(
            'Provided deadline %s is in the past from %s',
            $deadline->toString(),
            $deadline->createdOn()
        ));
    }
}
