<?php


declare(strict_types=1);

namespace App\Prooph\Model\User;

use Assert\Assertion;
use App\Prooph\Model\ValueObject;

final class UserName implements ValueObject
{
    /**
     * @var string
     */
    private $name;

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    private function __construct(string $name)
    {
        try {
            Assertion::notEmpty($name);
        } catch (\Exception $e) {
            throw Exception\InvalidName::reason($e->getMessage());
        }

        $this->name = $name;
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function sameValueAs(ValueObject $object): bool
    {
        return get_class($this) === get_class($object) && $this->name === $object->name;
    }
}
