<?php


declare(strict_types=1);

namespace App\Prooph\Projection\Todo;

use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;
use App\Prooph\Model\Todo\Event\ReminderWasAddedToTodo;
use App\Prooph\Model\Todo\Event\TodoAssigneeWasReminded;

final class TodoReminderProjection implements ReadModelProjection
{
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector
            ->fromStream('event_stream')
            ->when([
                ReminderWasAddedToTodo::class => function ($state, ReminderWasAddedToTodo $event) {
                    /** @var TodoReminderReadModel $readModel */
                    $readModel = $this->readModel();
                    $this->readModel()->stack('remove', [
                        'todo_id' => $event->todoId()->toString(),
                    ]);

                    $reminder = $event->reminder();

                    /** @var TodoReminderReadModel $readModel */
                    $readModel->stack('insert', [
                        'todo_id' => $event->todoId()->toString(),
                        'reminder' => $reminder->toString(),
                        'status' => $reminder->status()->toString(),
                    ]);
                },
                TodoAssigneeWasReminded::class => function ($state, TodoAssigneeWasReminded $event) {
                    /** @var TodoReminderReadModel $readModel */
                    $readModel->stack(
                        'update',
                        [
                            'status' => $event->reminder()->status()->toString(),
                        ],
                        [
                            'todo_id' => $event->todoId()->toString(),
                        ]
                    );
                },
            ]);

        return $projector;
    }
}
