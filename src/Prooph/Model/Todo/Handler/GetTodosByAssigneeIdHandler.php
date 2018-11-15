<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Handler;

use App\Prooph\Model\Todo\Query\GetTodosByAssigneeId;
use App\Prooph\Projection\Todo\TodoFinder;
use React\Promise\Deferred;

class GetTodosByAssigneeIdHandler
{
    private $todoFinder;

    public function __construct(TodoFinder $todoFinder)
    {
        $this->todoFinder = $todoFinder;
    }

    public function __invoke(GetTodosByAssigneeId $query, Deferred $deferred = null)
    {
        $todos = $this->todoFinder->findByAssigneeId($query->userId());
        if (null === $deferred) {
            return $todos;
        }

        $deferred->resolve($todos);
    }
}
