<?php

namespace App\Tests\Controller;

use Ramsey\Uuid\Uuid;

class TodoControllerTest extends ApiTestCase
{
    public function testCreateTodo()
    {
        $this->client->request('POST', '/todos',
            [
                'assignee_id' => Uuid::uuid4()->toString(),
                'todo_id' => Uuid::uuid4()->toString(),
                'text' => 'baz'
            ]
        );

        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }
}
