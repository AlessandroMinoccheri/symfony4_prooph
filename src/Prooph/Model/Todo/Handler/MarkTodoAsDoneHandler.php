<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Handler;

use App\Prooph\Model\Todo\Command\MarkTodoAsDone;
use App\Prooph\Model\Todo\Exception\TodoNotFound;
use App\Prooph\Model\Todo\TodoList;

class MarkTodoAsDoneHandler
{
    /**
     * @var TodoList
     */
    private $todoList;

    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    public function __invoke(MarkTodoAsDone $command): void
    {
        $todo = $this->todoList->get($command->todoId());

        if (! $todo) {
            throw TodoNotFound::withTodoId($command->todoId());
        }

        $todo->markAsDone();

        $this->todoList->save($todo);
    }
}
