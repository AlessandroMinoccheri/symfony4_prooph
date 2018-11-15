<?php


declare(strict_types=1);

namespace App\Prooph\Model\Post;

use App\Prooph\Model\ValueObject;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class PostId implements ValueObject
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    public static function generate(): PostId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $todoId): PostId
    {
        return new self(Uuid::fromString($todoId));
    }

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function sameValueAs(ValueObject $other): bool
    {
        return get_class($this) === get_class($other) && $this->uuid->equals($other->uuid);
    }
}
