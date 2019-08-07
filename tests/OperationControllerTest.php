<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OperationControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'username',
            'PHP_AUTH_PW' => 'entrer'

        ]);
        $crawler = $client->request(
            'POST',
            'api/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
    "numCompte":508201913,
    "nouveauSolde":100000
}'
        );

        $rep = $client->getResponse();
        var_dump($rep);
        $this->assertSame(201, $client->getResponse()->getStatusCode());
    }
}
