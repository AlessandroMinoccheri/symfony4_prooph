<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2017 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2017 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Prooph\Model\Todo\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use App\Prooph\Model\Todo\TodoId;
use App\Prooph\Model\Todo\TodoReminder;
use App\Prooph\Model\Todo\TodoReminderStatus;
use App\Prooph\Model\User\UserId;

final class AddReminderToTodo extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public function userId(): UserId
    {
        return UserId::fromString($this->payload['user_id']);
    }

    public function todoId(): TodoId
    {
        return TodoId::fromString($this->payload['todo_id']);
    }

    public function reminder(): TodoReminder
    {
        return TodoReminder::from($this->payload['reminder'], TodoReminderStatus::OPEN()->getName());
    }
}
