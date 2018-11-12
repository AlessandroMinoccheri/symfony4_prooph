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
