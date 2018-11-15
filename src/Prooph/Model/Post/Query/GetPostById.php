<?php


declare(strict_types=1);

namespace App\Prooph\Model\Post\Query;

final class GetPostById
{
    /**
     * @var string
     */
    private $postId;

    public function __construct(string $postId)
    {
        $this->postId = $postId;
    }

    public function postId(): string
    {
        return $this->postId;
    }
}
