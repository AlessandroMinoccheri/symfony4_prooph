<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Handler;

use App\Prooph\Model\Todo\Command\RemindTodoAssignee;
use App\Prooph\Model\Todo\Exception\TodoNotFound;
use App\Prooph\Model\Todo\Todo;
use App\Prooph\Model\Todo\TodoList;
use App\Prooph\Model\Todo\TodoReminder;

class RemindTodoAssigneeHandler
{
    /**
     * @var TodoList
     */
    private $todoList;

    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    public function __invoke(RemindTodoAssignee $command): void
    {
        $todo = $this->todoList->get($command->todoId());

        if (! $todo) {
            throw TodoNotFound::withTodoId($command->todoId());
        }

        $reminder = $todo->reminder();

        if ($this->reminderShouldBeProcessed($todo, $reminder)) {
            $todo->remindAssignee($reminder);

            $this->todoList->save($todo);
        }
    }

    private function reminderShouldBeProcessed(Todo $todo, TodoReminder $reminder): bool
    {
        // drop command, wrong reminder
        if (! $todo->reminder()->sameValueAs($reminder)) {
            return false;
        }

        // drop command, reminder is closed
        if (! $reminder->isOpen()) {
            return false;
        }

        // drop command, reminder is in future
        if ($reminder->isInTheFuture()) {
            return false;
        }

        return true;
    }
}
