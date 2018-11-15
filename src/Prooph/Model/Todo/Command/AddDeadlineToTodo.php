<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Command;

use Prooph\Common\Messaging;
use App\Prooph\Model\Todo\TodoDeadline;
use App\Prooph\Model\Todo\TodoId;
use App\Prooph\Model\User\UserId;

final class AddDeadlineToTodo extends Messaging\Command implements Messaging\PayloadConstructable
{
    use Messaging\PayloadTrait;

    public function userId(): UserId
    {
        return UserId::fromString($this->payload['user_id']);
    }

    public function todoId(): TodoId
    {
        return TodoId::fromString($this->payload['todo_id']);
    }

    public function deadline(): TodoDeadline
    {
        return TodoDeadline::fromString($this->payload['deadline']);
    }
}
