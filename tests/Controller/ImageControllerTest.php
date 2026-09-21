<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageControllerTest extends WebTestCase
{
    public function testUploadImage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/image');

        // Création d'un faux fichier image pour le test
        $photo = new UploadedFile(
            __DIR__ . '/../fixtures/test-image.png', // Chemin vers une vraie image de test
            'test-image.png',
            'image/png',
            null,
            true // Mode test
        );

        // Sélection et remplissage du champ du formulaire
        $form = $crawler->selectButton('Envoyer')->form([
            'image[Image]' => $photo,
        ]);

        $client->submit($form);

        // Vérifie la redirection vers l'affichage
        $this->assertResponseRedirects('/image/show');
    }
}