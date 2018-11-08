<?php

namespace App\Tests\Controller;

use Ramsey\Uuid\Uuid;

class PostControllerTest extends ApiTestCase
{
    public function testCreateTodo()
    {
        $this->client->request('POST', '/posts',
            [
                'post_id' => Uuid::uuid4()->toString(),
                'text' => 'text' . random_int(1, 99999),
                'description' => 'description' . random_int(1, 99999),
            ]
        );

        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }
}
