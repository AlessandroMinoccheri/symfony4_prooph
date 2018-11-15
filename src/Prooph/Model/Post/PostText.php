<?php


declare(strict_types=1);

namespace App\Prooph\Model\Post;

use Assert\Assertion;
use App\Prooph\Model\ValueObject;

final class PostText implements ValueObject
{
    /**
     * @var string
     */
    private $text;

    public static function fromString(string $text): self
    {
        return new self($text);
    }

    private function __construct(string $text)
    {
        try {
            Assertion::minLength($text, 3);
        } catch (\Exception $e) {
            throw Exception\InvalidText::reason($e->getMessage());
        }

        $this->text = $text;
    }

    public function toString(): string
    {
        return $this->text;
    }

    public function sameValueAs(ValueObject $object): bool
    {
        return get_class($this) === get_class($object) && $this->text === $object->text;
    }
}
