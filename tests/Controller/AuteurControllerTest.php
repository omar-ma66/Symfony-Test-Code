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

        // Vérifie la réponse 200 OK
        $this->assertResponseIsSuccessful();
        // Vérifie qu'on est sur le bon template ou contenu
        $this->assertSelectorTextContains('h1', 'Liste'); 
    }

    // 2. Test du contrôle d'accès #[IsGranted('ROLE_USER')]
    public function testAuteurNouveauRedirigeSiNonConnecte(): void
    {
        $client = static::createClient();
        $client->request('GET', '/auteur/nouveau');

        // Un utilisateur non connecté doit être redirigé vers la page de login
        $this->assertResponseRedirects('/login');
    }

    // 3. Test de création d'un auteur avec un utilisateur connecté
    public function testCreationAuteurReussie(): void
    {
        $client = static::createClient();

        // Récupération d'un utilisateur de test depuis la base de données
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('user@test.com');

        // Connexion de l'utilisateur
        $client->loginUser($testUser);

        // Soumission du formulaire
        $crawler = $client->request('GET', '/auteur/nouveau');
        $form = $crawler->selectButton('Enregistrer')->form([
            'auteur[nom]' => 'Hugo',
            'auteur[prenom]' => 'Victor',
        ]);

        $client->submit($form);

        // Vérifie la redirection vers la liste des auteurs après la création
        $this->assertResponseRedirects('/auteur/liste');

        // Suit la redirection
        $client->followRedirect();

        // Vérifie le message flash de succès
        $this->assertSelectorExists('.alert-success');
    }
}