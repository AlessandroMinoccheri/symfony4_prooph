<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Handler;

use App\Prooph\Model\Todo\Command\AddDeadlineToTodo;
use App\Prooph\Model\Todo\TodoList;

class AddDeadlineToTodoHandler
{
    /**
     * @var TodoList
     */
    private $todoList;

    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    public function __invoke(AddDeadlineToTodo $command): void
    {
        $todo = $this->todoList->get($command->todoId());
        $todo->addDeadline($command->userId(), $command->deadline());

        $this->todoList->save($todo);
    }
}
