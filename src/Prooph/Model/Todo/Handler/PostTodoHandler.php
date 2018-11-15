<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Handler;

use App\Prooph\Model\Todo\Command\PostTodo;
use App\Prooph\Model\Todo\Todo;
use App\Prooph\Model\Todo\TodoList;
use App\Prooph\Model\User\Exception\UserNotFound;
use App\Prooph\Model\User\UserCollection;

class PostTodoHandler
{
    /**
     * @var TodoList
     */
    private $todoList;

    /**
     * @var UserCollection
     */
    private $userCollection;

    public function __construct(UserCollection $userCollection, TodoList $todoList)
    {
        $this->userCollection = $userCollection;
        $this->todoList = $todoList;
    }

    /**
     * @throws UserNotFound
     */
    public function __invoke(PostTodo $command): void
    {
        //$user = $this->userCollection->get($command->assigneeId());

        $userId = $command->assigneeId();

        //if (! $user) {
        //    throw UserNotFound::withUserId($command->assigneeId());
        //}

        //$todo = $user->postTodo($command->text(), $command->todoId());

        $todo = Todo::post($command->text(), $userId, $command->todoId());

        $this->todoList->save($todo);
    }
}
