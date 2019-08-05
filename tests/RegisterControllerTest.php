<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'username',
            'PHP_AUTH_PW'=>'entrer' 

         ]);        
         $crawler = $client->request('POST', 'api/register',[],[],
         ['CONTENT_TYPE' => 'application/json'],
        '
        {
            "username":"kimora",
            "roles":["ROLE_USER"],
            "password":"entrer",
            "etatU":"actif",
            "adresseU":"dieuppeul 2",
            "nom":"ndiaye",
            "prenom":"kim",
            "nompartenaire":"moussa ndiaye",
            "adresseP":"dakar",
            "raisonSociale":"ndiaye SA",
            "ninea":"100",
            "etatP":"actif",
            "numcomptP":25456,
            "soldeP":"10000000",
            "numCompte":"87963",
            "proprioCompte":"moussa ndiaye",
            "depot":"75000"
             }
        '
        
        );

        $rep = $client->getResponse();
         var_dump($rep);
        $this->assertSame(201, $client->getResponse()->getStatusCode());
    }
}
