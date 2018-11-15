<?php


declare(strict_types=1);

namespace App\Prooph\Model\Todo\Exception;

final class InvalidText extends \InvalidArgumentException
{
    public static function reason(string $msg): InvalidText
    {
        return new self('The todo text is invalid: ' . $msg);
    }
}
