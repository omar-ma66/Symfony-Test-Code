<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AuteurControllerTest extends WebTestCase
{
    // 1. Test d'une route publique GET
    public function testListeAuteursRetourneStatus200(): void
    {
        $client = static::createClient();
        $client->request('GET', '/auteur/liste');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste');
    }

    // 2. Test du contrôle d'accès #[IsGranted('ROLE_USER')]
    public function testAuteurNouveauRedirigeSiNonConnecte(): void
    {
        $client = static::createClient();
        $client->request('GET', '/auteur/nouveau');
        $this->assertResponseRedirects('/login');
    }

    // 3. Test de création d'un auteur avec un utilisateur connecté
    public function testCreationAuteurReussie(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.com');
        // $testUser = $userRepository->findOneByEmail('user@test.com');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/auteur/nouveau');
        //  dd($client->getResponse()->getContent());

        $form = $crawler->selectButton('Enregistrer')->form([
            'auteur[nom]' => 'Hugo',
            'auteur[prenom]' => 'Victor',
        ]);
        $client->submit($form);
        // dd($client->getResponse()->getContent());
        $this->assertResponseRedirects('/auteur/liste');
        $client->followRedirect(); // suivre le redirection
        $this->assertSelectorExists('.flash-success');
    }
}
