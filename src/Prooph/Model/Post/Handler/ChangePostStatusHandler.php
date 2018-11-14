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

use App\Prooph\Model\Post\Command\ChangePostStatus;
use App\Prooph\Model\Post\PostList;

class ChangePostStatusHandler
{
    /**
     * @var PostList
     */
    private $postList;

    public function __construct(PostList $postList)
    {
        $this->postList = $postList;
    }

    public function __invoke(ChangePostStatus $command): void
    {
        $post = $this->postList->get($command->postId());
        $post->changeStatus($command->status());

        $this->postList->save($post);
    }
}


