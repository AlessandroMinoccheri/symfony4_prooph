<?php


declare(strict_types=1);

namespace App\Prooph\Projection\Todo;

use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;
use App\Prooph\Model\Todo\Event\DeadlineWasAddedToTodo;
use App\Prooph\Model\Todo\Event\ReminderWasAddedToTodo;
use App\Prooph\Model\Todo\Event\TodoWasMarkedAsDone;
use App\Prooph\Model\Todo\Event\TodoWasMarkedAsExpired;
use App\Prooph\Model\Todo\Event\TodoWasPosted;
use App\Prooph\Model\Todo\Event\TodoWasReopened;
use App\Prooph\Model\Todo\Event\TodoWasUnmarkedAsExpired;

final class TodoProjection implements ReadModelProjection
{

    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector->fromStream('event_stream')
            ->when([
                TodoWasPosted::class => function ($state, TodoWasPosted $event) {
                    /** @var TodoReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack('insert', [
                        'id' => $event->todoId()->toString(),
                        'assignee_id' => $event->assigneeId()->toString(),
                        'text' => $event->text()->toString(),
                        'status' => $event->todoStatus()->toString(),
                    ]);
                },
                TodoWasMarkedAsDone::class => function ($state, TodoWasMarkedAsDone $event) {
                    /** @var TodoReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack(
                        'update',
                        [
                            'status' => $event->newStatus()->toString(),
                        ],
                        [
                            'id' => $event->todoId()->toString(),
                        ]
                    );
                },
                TodoWasReopened::class => function ($state, TodoWasReopened $event) {
                    /** @var TodoReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack(
                        'update',
                        [
                            'status' => $event->status()->toString(),
                        ],
                        [
                            'id' => $event->todoId()->toString(),
                        ]
                    );
                },
                DeadlineWasAddedToTodo::class => function ($state, DeadlineWasAddedToTodo $event) {
                    /** @var TodoReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack(
                        'update',
                        [
                            'deadline' => $event->deadline()->toString(),
                        ],
                        [
                            'id' => $event->todoId()->toString(),
                        ]
                    );
                },
                ReminderWasAddedToTodo::class => function ($state, ReminderWasAddedToTodo $event) {
                    /** @var TodoReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack(
                        'update',
                        [
                            'reminder' => $event->reminder()->toString(),
                        ],
                        [
                            'id' => $event->todoId()->toString(),
                        ]
                    );
                },
                TodoWasMarkedAsExpired::class => function ($state, TodoWasMarkedAsExpired $event) {
                    /** @var TodoReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack(
                        'update',
                        [
                            'status' => $event->newStatus()->toString(),
                        ],
                        [
                            'id' => $event->todoId()->toString(),
                        ]
                    );
                },
                TodoWasUnmarkedAsExpired::class => function ($state, TodoWasUnmarkedAsExpired $event) {
                    /** @var TodoReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack(
                        'update',
                        [
                            'status' => $event->newStatus()->toString(),
                        ],
                        [
                            'id' => $event->todoId()->toString(),
                        ]
                    );
                },
            ]);

        return $projector;
    }
}
