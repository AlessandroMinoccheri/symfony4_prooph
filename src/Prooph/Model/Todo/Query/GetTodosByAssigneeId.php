<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Query;

final class GetTodosByAssigneeId
{
    /**
     * @var string
     */
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function userId(): string
    {
        return $this->userId;
    }
}
