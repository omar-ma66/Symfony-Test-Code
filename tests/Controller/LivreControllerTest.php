<?php
namespace App\Tests\Controller;

use App\Repository\LivreRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LivreControllerTest extends WebTestCase
{
    public function testSuppressionLivreAvecRoleAdmin(): void
    {
        $client = static::createClient();

        // Connexion avec un compte ADMIN
        $userRepository = static::getContainer()->get(UserRepository::class);
        $adminUser = $userRepository->findOneByEmail('admin@test.com');
        $client->loginUser($adminUser);

        // Récupération d'un livre à supprimer
        $livreRepository = static::getContainer()->get(LivreRepository::class);
        $livre = $livreRepository->findOneBy([]);

        // Génération ou récupération du jeton CSRF depuis la page ou l'environnement de test
        $crawler = $client->request('GET', '/livre/');
        
        // Exécution de la requête POST de suppression
        $client->request('POST', '/livre/supprime/' . $livre->getId(), [
            '_token' => $client->getContainer()->get('security.csrf.token_manager')->getToken('delete' . $livre->getId())->getValue()
        ]);

        $this->assertResponseRedirects('/livre');
    }
}