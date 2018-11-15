<?php


declare(strict_types=1);

namespace App\Prooph\Projection\Post;

use Doctrine\DBAL\Connection;
use App\Prooph\Model\Todo\TodoStatus;
use App\Prooph\Projection\Table;

class PostFinder
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
        return $this->connection->fetchAll(sprintf('SELECT * FROM %s', Table::POST));
    }

    public function findById(string $postId): ?\stdClass
    {
        $stmt = $this->connection->prepare(sprintf('SELECT * FROM %s where id = :post_id', Table::POST));
        $stmt->bindValue('post_id', $postId);
        $stmt->execute();

        $result = $stmt->fetch();

        if (false === $result) {
            return null;
        }

        return $result;
    }

    public function findByWriterId(string $writerId): array
    {
        return $this->connection->fetchAll(
            sprintf('SELECT * FROM %s WHERE writer_id = :writer_id', Table::POST),
            ['writer_id' => $writerId]
        );
    }
}
