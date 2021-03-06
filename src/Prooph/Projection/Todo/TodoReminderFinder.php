<?php


declare(strict_types=1);

namespace App\Prooph\Projection\Todo;

use Doctrine\DBAL\Connection;
use App\Prooph\Model\Todo\TodoReminderStatus;
use App\Prooph\Projection\Table;

class TodoReminderFinder
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

    public function findOpen(): array
    {
        $stmt = $this->connection->prepare(
            sprintf(
                "SELECT * FROM %s where reminder < NOW() AND status = '%s'",
                Table::TODO_REMINDER,
                TodoReminderStatus::OPEN
            )
        );
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
