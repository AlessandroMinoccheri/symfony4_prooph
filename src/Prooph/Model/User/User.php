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

namespace App\Prooph\Model\User;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use App\Prooph\Model\Entity;
use App\Prooph\Model\Todo\Todo;
use App\Prooph\Model\Todo\TodoId;
use App\Prooph\Model\Todo\TodoText;

final class User extends AggregateRoot implements Entity
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var UserName
     */
    private $name;

    /**
     * @var EmailAddress
     */
    private $emailAddress;

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function emailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }

    public function postTodo(TodoText $text, TodoId $todoId): Todo
    {
        return Todo::post($text, $this->userId(), $todoId);
    }

    protected function aggregateId(): string
    {
        return $this->userId->toString();
    }

    public function sameIdentityAs(Entity $other): bool
    {
        return get_class($this) === get_class($other) && $this->userId->sameValueAs($other->userId);
    }

    /**
     * Apply given event
     */
    protected function apply(AggregateChanged $e): void
    {
        $handler = $this->determineEventHandlerMethodFor($e);

        if (! method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                get_class($this)
            ));
        }

        $this->{$handler}($e);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $e): string
    {
        return 'when' . implode(array_slice(explode('\\', get_class($e)), -1));
    }
}
