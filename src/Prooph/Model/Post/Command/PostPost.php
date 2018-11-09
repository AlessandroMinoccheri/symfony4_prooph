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

namespace App\Prooph\Model\Post\Command;

use App\Prooph\Model\Post\PostDescription;
use App\Prooph\Model\Post\PostId;
use App\Prooph\Model\Post\PostText;
use App\Prooph\Model\User\UserId;
use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

final class PostPost extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public function postId(): PostId
    {
        return PostId::fromString($this->payload['post_id']);
    }

    public function text(): PostText
    {
        return PostText::fromString($this->payload['text']);
    }

    public function description(): PostDescription
    {
        return PostDescription::fromString($this->payload['description']);
    }

    public function writerId(): UserId
    {
        return UserId::fromString($this->payload['writer_id']);
    }

    protected function setPayload(array $payload): void
    {
        Assertion::keyExists($payload, 'post_id');
        Assertion::uuid($payload['post_id']);
        Assertion::keyExists($payload, 'writer_id');
        Assertion::uuid($payload['writer_id']);
        Assertion::keyExists($payload, 'text');
        Assertion::string($payload['text']);
        Assertion::keyExists($payload, 'description');
        Assertion::string($payload['description']);

        $this->payload = $payload;
    }
}
