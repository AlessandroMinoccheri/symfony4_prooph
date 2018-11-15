<?php


declare(strict_types=1);

namespace App\Prooph\Model\User\Handler;

use App\Prooph\Model\User\Query\GetAllUsers;
use App\Prooph\Projection\User\UserFinder;
use React\Promise\Deferred;

class GetAllUsersHandler
{
    private $userFinder;

    public function __construct(UserFinder $userFinder)
    {
        $this->userFinder = $userFinder;
    }

    public function __invoke(GetAllUsers $query, Deferred $deferred = null)
    {
        $user = $this->userFinder->findAll();
        if (null === $deferred) {
            return $user;
        }

        $deferred->resolve($user);
    }
}
