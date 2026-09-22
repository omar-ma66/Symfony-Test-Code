<?php

namespace App\Tests\Controller;

use App\Repository\LivreRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LivreControllerTest extends WebTestCase
{
    public function testSuppressionLivreAvecRoleAdmin(): void
    {
        // Création du client de test
        $client = static::createClient();

        // ==========================================================
        // 1. Récupération de l'utilisateur ADMIN
        // ==========================================================

        $userRepository = static::getContainer()
            ->get(UserRepository::class);

        $adminUser = $userRepository
            ->findOneByEmail('admin@admin.com');

        $this->assertNotNull($adminUser);

        // Connexion en tant qu'administrateur
        $client->loginUser($adminUser);

        // ==========================================================
        // 2. Récupération d'un livre
        // ==========================================================

        $livreRepository = static::getContainer()
            ->get(LivreRepository::class);

        $livre = $livreRepository->findOneBy([]);

        $this->assertNotNull($livre);

        // ==========================================================
        // 3. Chargement de la page des livres
        // ==========================================================

        $crawler = $client->request('GET', '/livre/');

        // Vérifie que la page est accessible
        $this->assertResponseIsSuccessful();

        // ==========================================================
        // 4. Diagnostic
        // ==========================================================

        dump('ID DU LIVRE = ' . $livre->getId());

        dump(
            'NOMBRE DE FORMULAIRES = ' .
            $crawler->filter('form')->count()
        );

        dump(
            'NOMBRE DE TOKENS CSRF = ' .
            $crawler->filter('input[name="_token"]')->count()
        );

        // Recherche du formulaire correspondant exactement
        // au livre que nous voulons supprimer.
        $form = $crawler->filter(
            'form[action="/livre/supprime/' . $livre->getId() . '"]'
        );

        dump(
            'NOMBRE DE FORMULAIRE CIBLE = ' .
            $form->count()
        );

        // ==========================================================
        // 5. Vérification que le formulaire existe
        // ==========================================================

        $this->assertCount(
            1,
            $form,
            'Le formulaire de suppression du livre n\'a pas été trouvé.'
        );

        // ==========================================================
        // 6. Récupération du token CSRF
        // ==========================================================

        $csrfTokenNode = $form->filter('input[name="_token"]');

        $this->assertCount(
            1,
            $csrfTokenNode,
            'Le token CSRF n\'a pas été trouvé dans le formulaire.'
        );

        $csrfToken = $csrfTokenNode->attr('value');

        $this->assertNotEmpty(
            $csrfToken,
            'Le token CSRF est vide.'
        );

        // ==========================================================
        // 7. Suppression du livre
        // ==========================================================

        $client->request(
            'POST',
            '/livre/supprime/' . $livre->getId(),
            [
                '_token' => $csrfToken
            ]
        );

        // ==========================================================
        // 8. Vérification de la redirection
        // ==========================================================

        $this->assertResponseRedirects('/livre/');
    }
}


// class LivreControllerTest extends WebTestCase
// {

//     public function testSuppressionLivreAvecRoleAdmin(): void
//     {
//         $client = static::createClient();

//         $userRepository = static::getContainer()->get(UserRepository::class);
//         $adminUser = $userRepository->findOneByEmail('admin@admin.com');
//         $client->loginUser($adminUser);


//         $livreRepository = static::getContainer()->get(LivreRepository::class);
//         $livre = $livreRepository->findOneBy([]);


//         $crawler = $client->request('GET', '/livre');



//         $form = $crawler->filter(
//     'form[action="/livre/supprime/' . $livre->getId() . '"]'
// );

// $csrfToken = $form->filter('input[name="_token"]')->attr('value');


//         $client->request('POST', '/livre/supprime/' . $livre->getId(), [
//             '_token' => $csrfToken
//         ]);

//         $this->assertResponseRedirects('/livre');
//     }
// }
