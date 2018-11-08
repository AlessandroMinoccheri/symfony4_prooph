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

namespace App\Prooph\Model\Todo\Command;

use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use App\Prooph\Model\Todo\TodoId;
use App\Prooph\Model\Todo\TodoText;
use App\Prooph\Model\User\UserId;

final class PostTodo extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function forUser(string $assigneeId, string $text, string $todoId): PostTodo
    {
        return new self([
            'assignee_id' => $assigneeId,
            'todo_id' => $todoId,
            'text' => $text,
        ]);
    }

    public function todoId(): TodoId
    {
        return TodoId::fromString($this->payload['todo_id']);
    }

    public function assigneeId(): UserId
    {
        return UserId::fromString($this->payload['assignee_id']);
    }

    public function text(): TodoText
    {
        return TodoText::fromString($this->payload['text']);
    }

    protected function setPayload(array $payload): void
    {
        Assertion::keyExists($payload, 'assignee_id');
        Assertion::uuid($payload['assignee_id']);
        Assertion::keyExists($payload, 'todo_id');
        Assertion::uuid($payload['todo_id']);
        Assertion::keyExists($payload, 'text');
        Assertion::string($payload['text']);

        $this->payload = $payload;
    }
}