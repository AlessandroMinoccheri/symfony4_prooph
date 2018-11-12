<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2017 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2017 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
