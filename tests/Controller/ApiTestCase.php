<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class ApiTestCase extends WebTestCase
{
    protected $client;

    protected $manager;

    protected $connection;

    public function getContainer()
    {
        if (!$this->client) {
            throw new \Exception('Client NULL');
        }

        return $this->client->getContainer();
    }

    protected function setUp()
    {
        $this->client = static::createClient(array(
            'environment' => 'test',
            'debug' => false,
        ));

        $this->manager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $this->connection = $this->manager->getConnection();
    }
}
