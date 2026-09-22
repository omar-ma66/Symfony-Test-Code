<?php

namespace App\Tests\Controller;

use App\Repository\LivreRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class LivreControllerTest extends WebTestCase
// {
//     public function testSuppressionLivreAvecRoleAdmin(): void
//     {
      
//         $client = static::createClient();

      

//         $userRepository = static::getContainer()
//             ->get(UserRepository::class);

//         $adminUser = $userRepository
//             ->findOneByEmail('admin@admin.com');

//         $this->assertNotNull($adminUser);

   
//         $client->loginUser($adminUser);

     

//         $livreRepository = static::getContainer()
//             ->get(LivreRepository::class);

//         $livre = $livreRepository->findOneBy([]);

//         $this->assertNotNull($livre);

      

//         $crawler = $client->request('GET', '/livre/');

       
//         $this->assertResponseIsSuccessful();

     

//         dump('ID DU LIVRE = ' . $livre->getId());

//         dump(
//             'NOMBRE DE FORMULAIRES = ' .
//             $crawler->filter('form')->count()
//         );

//         dump(
//             'NOMBRE DE TOKENS CSRF = ' .
//             $crawler->filter('input[name="_token"]')->count()
//         );

      
//         $form = $crawler->filter(
//             'form[action="/livre/supprime/' . $livre->getId() . '"]'
//         );

//         dump(
//             'NOMBRE DE FORMULAIRE CIBLE = ' .
//             $form->count()
//         );

    
//         $this->assertCount(
//             1,
//             $form,
//             'Le formulaire de suppression du livre n\'a pas été trouvé.'
//         );

      

//         $csrfTokenNode = $form->filter('input[name="_token"]');

//         $this->assertCount(
//             1,
//             $csrfTokenNode,
//             'Le token CSRF n\'a pas été trouvé dans le formulaire.'
//         );

//         $csrfToken = $csrfTokenNode->attr('value');

//         $this->assertNotEmpty(
//             $csrfToken,
//             'Le token CSRF est vide.'
//         );

      

//         $client->request(
//             'POST',
//             '/livre/supprime/' . $livre->getId(),
//             [
//                 '_token' => $csrfToken
//             ]
//         );
//         $this->assertResponseRedirects('/livre/');
//     }
// }


class LivreControllerTest extends WebTestCase
{

    public function testSuppressionLivreAvecRoleAdmin(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $adminUser = $userRepository->findOneByEmail('admin@admin.com');
        $client->loginUser($adminUser);
        $livreRepository = static::getContainer()->get(LivreRepository::class);
        $livre = $livreRepository->findOneBy([]);
        $crawler = $client->request('GET', '/livre/');
        $form = $crawler->filter(
    'form[action="/livre/supprime/' . $livre->getId() . '"]'
);
$csrfToken = $form->filter('input[name="_token"]')->attr('value');
        $client->request('POST', '/livre/supprime/' . $livre->getId(), [
            '_token' => $csrfToken
        ]);

        $this->assertResponseRedirects('/livre/');
    }
}

