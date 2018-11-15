<?php


declare(strict_types=1);

namespace App\Prooph\Model;

interface ValueObject
{
    public function sameValueAs(ValueObject $object): bool;
}
