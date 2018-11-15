<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo;

use App\Prooph\Model\Enum;

/**
 * @method static TodoStatus OPEN()
 * @method static TodoStatus DONE()
 * @method static TodoStatus EXPIRED()
 */
final class TodoStatus extends Enum
{
    public const OPEN = 'open';
    public const DONE = 'done';
    public const EXPIRED = 'expired';
}
