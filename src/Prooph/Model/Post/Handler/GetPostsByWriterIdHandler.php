<?php


declare(strict_types=1);

namespace App\Prooph\Model\Post\Handler;

use App\Prooph\Model\Post\Query\GetPostsByAssigneeId;
use App\Prooph\Projection\Post\PostFinder;

class GetPostsByWriterIdHandler
{
    private $postFinder;

    public function __construct(PostFinder $postFinder)
    {
        $this->postFinder = $postFinder;
    }

    public function __invoke(GetPostsByAssigneeId $query)
    {
        return $this->postFinder->findByWriterId($query->userId());
    }
}
