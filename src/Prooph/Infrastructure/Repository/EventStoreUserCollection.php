<?php


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
