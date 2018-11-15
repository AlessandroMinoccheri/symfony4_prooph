<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo;

interface TodoList
{
    public function save(Todo $todo): void;

    public function get(TodoId $todoId): ?Todo;
}
