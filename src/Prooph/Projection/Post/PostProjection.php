<?php


declare(strict_types=1);

namespace App\Prooph\Projection\Post;

use App\Prooph\Model\Post\Event\PostWasPosted;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;

final class PostProjection implements ReadModelProjection
{

    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector->fromStream('event_stream')
            ->when([
                PostWasPosted::class => function ($state, PostWasPosted $event) {
                    /** @var PostReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack('insert', [
                        'id' => $event->postId()->toString(),
                        'writer_id' => $event->writerId()->toString(),
                        'text' => $event->text()->toString(),
                        'description' => $event->description()->toString(),
                    ]);
                },
            ]);

        return $projector;
    }
}
