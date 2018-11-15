<?php


declare(strict_types=1);

namespace App\Prooph\Model\User\Handler;

use App\Prooph\Model\User\Query\GetUserById;
use App\Prooph\Projection\User\UserFinder;
use React\Promise\Deferred;

class GetUserByIdHandler
{
    private $userFinder;

    public function __construct(UserFinder $userFinder)
    {
        $this->userFinder = $userFinder;
    }

    public function __invoke(GetUserById $query, Deferred $deferred = null)
    {
        $user = $this->userFinder->findById($query->userId());
        if (null === $deferred) {
            return $user;
        }

        $deferred->resolve($user);
    }
}
