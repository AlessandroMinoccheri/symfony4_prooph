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
