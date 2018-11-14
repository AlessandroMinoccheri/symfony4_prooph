<?php

declare(strict_types=1);

namespace App\Prooph\Model\Post;

use App\Prooph\Model\Enum;

/**
 * @method static PostStatus DRAFT()
 * @method static PostStatus PUBLIC()
 * @method static PostStatus DELETED()
 */
final class PostStatus extends Enum
{
    public const DRAFT = 'draft';
    public const PUBLIC = 'public';
    public const DELETED = 'deleted';
}
