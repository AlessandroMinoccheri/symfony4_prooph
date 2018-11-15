<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Query;

final class GetTodoById
{
    /**
     * @var string
     */
    private $todoId;

    public function __construct(string $todoId)
    {
        $this->todoId = $todoId;
    }

    public function todoId(): string
    {
        return $this->todoId;
    }
}
