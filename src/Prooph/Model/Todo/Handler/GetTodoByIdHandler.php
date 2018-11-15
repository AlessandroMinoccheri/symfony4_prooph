<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Handler;

use App\Prooph\Model\Todo\Query\GetTodoById;
use App\Prooph\Projection\Todo\TodoFinder;
use React\Promise\Deferred;

class GetTodoByIdHandler
{
    private $todoFinder;

    public function __construct(TodoFinder $todoFinder)
    {
        $this->todoFinder = $todoFinder;
    }

    public function __invoke(GetTodoById $query, Deferred $deferred = null)
    {
        $todo = $this->todoFinder->findById($query->todoId());
        if (null === $deferred) {
            return $todo;
        }

        $deferred->resolve($todo);
    }
}
