<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo;

use App\Prooph\Model\Enum;

/**
 * @method static TodoReminderStatus OPEN()
 * @method static TodoReminderStatus CLOSED()
 */
final class TodoReminderStatus extends Enum
{
    public const OPEN = 'open';
    public const CLOSED = 'closed';
}
