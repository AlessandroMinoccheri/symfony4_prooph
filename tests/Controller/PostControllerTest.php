<?php

namespace App\Tests\Controller;

use Ramsey\Uuid\Uuid;

class PostControllerTest extends ApiTestCase
{
    public function testCreatePost()
    {
        $this->client->request('POST', '/posts',
            [
                'writer_id' => Uuid::uuid4()->toString(),
                'text' => 'text' . random_int(1, 99999),
                'description' => 'description' . random_int(1, 99999),
            ]
        );

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    public function testGetPostList()
    {
        $this->client->request('POST', '/posts',
            [
                'writer_id' => Uuid::uuid4()->toString(),
                'text' => 'text' . random_int(1, 99999),
                'description' => 'description' . random_int(1, 99999),
            ]
        );

        $content = json_decode($this->client->getResponse()->getContent(), true);

        $postId = $content['post'];

        $this->client->request('GET', '/posts/' . $postId);

        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
