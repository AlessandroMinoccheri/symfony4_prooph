<?php


declare(strict_types=1);

namespace App\Prooph\Projection\Post;

use Doctrine\DBAL\Connection;
use Prooph\EventStore\Projection\AbstractReadModel;
use App\Prooph\Projection\Table;

final class PostReadModel extends AbstractReadModel
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function init(): void
    {
        $tableName = Table::POST;

        $sql = <<<EOT
CREATE TABLE `$tableName` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `writer_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_a_status` (`writer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
EOT;

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    public function isInitialized(): bool
    {
        $tableName = Table::POST;

        $sql = "SHOW TABLES LIKE '$tableName';";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        $result = $statement->fetch();

        if (false === $result) {
            return false;
        }

        return true;
    }

    public function reset(): void
    {
        $tableName = Table::POST;

        $sql = "TRUNCATE TABLE '$tableName';";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    public function delete(): void
    {
        $tableName = Table::POST;

        $sql = "DROP TABLE $tableName;";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    protected function insert(array $data): void
    {
        $this->connection->insert(Table::POST, $data);
    }

    protected function update(array $data, array $identifier): void
    {
        $this->connection->update(
            Table::POST,
            $data,
            $identifier
        );
    }
}
