<?php


declare(strict_types=1);

namespace App\Prooph\Model\User;

interface UserCollection
{
    public function save(User $user): void;

    public function get(UserId $userId): ?User;
}
