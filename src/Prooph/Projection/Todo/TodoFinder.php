<?php


declare(strict_types=1);

namespace App\Prooph\Projection\Todo;

use Doctrine\DBAL\Connection;
use App\Prooph\Model\Todo\TodoStatus;
use App\Prooph\Projection\Table;

class TodoFinder
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->connection->setFetchMode(\PDO::FETCH_OBJ);
    }

    public function findAll(): array
    {
        return $this->connection->fetchAll(sprintf('SELECT * FROM %s', Table::TODO));
    }

    public function findAllOpen(): array
    {
        return $this->connection->fetchAll(sprintf("SELECT * FROM %s WHERE status = '%s'", Table::TODO, TodoStatus::OPEN));
    }

    public function findByAssigneeId(string $assigneeId): array
    {
        return $this->connection->fetchAll(
            sprintf('SELECT * FROM %s WHERE assignee_id = :assignee_id', Table::TODO),
            ['assignee_id' => $assigneeId]
        );
    }

    public function findById(string $todoId): ?\stdClass
    {
        $stmt = $this->connection->prepare(sprintf('SELECT * FROM %s where id = :todo_id', Table::TODO));
        $stmt->bindValue('todo_id', $todoId);
        $stmt->execute();

        $result = $stmt->fetch();

        if (false === $result) {
            return null;
        }

        return $result;
    }

    public function findByOpenReminders(): array
    {
        $stmt = $this->connection->prepare(sprintf('SELECT * FROM %s where reminder < NOW() AND reminded = 0', Table::TODO));
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findOpenWithPastTheirDeadline(): array
    {
        return $this->connection->fetchAll(
            sprintf(
                "SELECT * FROM %s WHERE status = :status AND deadline < CONVERT_TZ(NOW(), @@session.time_zone, '+00:00')",
                Table::TODO
            ), [
                'status' => TodoStatus::OPEN,
            ]
        );
    }
}
