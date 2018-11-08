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

namespace App\Prooph\Infrastructure\Repository;

use Prooph\EventSourcing\Aggregate\AggregateRepository;
use App\Prooph\Model\User\User;
use App\Prooph\Model\User\UserCollection;
use App\Prooph\Model\User\UserId;

final class EventStoreUserCollection extends AggregateRepository implements UserCollection
{
    public function save(User $user): void
    {
        $this->saveAggregateRoot($user);
    }

    public function get(UserId $userId): ?User
    {
        return $this->getAggregateRoot($userId->toString());
    }
}
