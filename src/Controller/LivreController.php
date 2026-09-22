<?php

namespace App\Controller;

use App\Service\CalculatriceService;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Form\LivreType;
use App\Repository\LivreRepository;
// use Dba\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\DBAL\Connection;

// ####################################################################
#[Route('/livre')]
final class LivreController extends AbstractController
{
    #[Route('/', name: 'app_livre', methods: ['GET'])]
    public function index(LivreRepository $livre): Response
    {
        $all =    $livre->findAll();
        return $this->render('livre/index2.html.twig', [
            "livres" => $all
        ]);
    }
    // ####################################################################

    #[Route('/new', name: 'app_livre_create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($livre);
            $em->flush();
            $this->addFlash('success', "votre livre a bien été enregistré");

            return $this->redirectToRoute("app_livre");
        }

        return   $this->render(
            "livre/create.html.twig",
            [
                "form" => $form
            ]
        );
    }

    // ####################################################################


    #[Route('/supprime/{id}', name: 'app_livre_delete', methods: ['POST'], requirements: ['id' => Requirement::DIGITS])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, EntityManagerInterface $em, Livre $livre): Response
    {

        if ($this->isCsrfTokenValid('delete' . $livre->getId(), (string) $request->request->get('_token'))) {
            $em->remove($livre);

            $em->flush();
            $this->addFlash('success', 'votre livre a bien été supprimé ');
        }
        return $this->redirectToRoute('app_livre');
    }

    // ####################################################################
    #[Route('/update/{id}', name: 'app_livre_update', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    #[IsGranted('ROLE_USER')]
    public function update(Request $request, Livre $livre, EntityManagerInterface $em, LivreRepository $lr): Response
    {
        $auteurID   =  $livre->getAuteur();
        $listeLivres =              $lr->findBy(["auteur" => $auteurID]);

        dump($listeLivres);
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', "votre livre a bien été mis a jour");

            //   return  $this->redirectToRoute('app_livre');
            return  $this->redirectToRoute('app_livre', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('livre/update.html.twig', ["form" => $form, "livre" => $livre, 'listelivres' => $listeLivres]);
    }
    // ####################################################################
    #[Route('/sql/{id}', name: 'app_test_sql', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function testSql(Connection $con, int $id, EntityManagerInterface $em): Response
    {
        $sql = "SELECT * FROM livre where id > :id ";


        $resultat = $con->fetchAllAssociative($sql, ['id' => $id]);

        $livre = $em->find(Livre::class, 3);
        $auteur = $em->find(Auteur::class, 3);


        return $this->render('livre/testSql.html.twig', [
            "resultat" => $resultat,
            "id" => $id,
            "livre" => $livre,
            "auteur" => $auteur,
        ]);
    }
    #[Route('/test-service')]
    public function testService(CalculatriceService $calculatrice, LivreRepository $lr): Response
    {
        $book =  $lr->findAll();
        $prixTotal = $calculatrice->total($book);
        $book =  $lr->findBy(["categorie" => "roman"]);
        $prixRoman =  $calculatrice->total($book);
        $book =  $lr->findBy(["categorie" => "science"]);
        $prixScience =  $calculatrice->total($book);
        $book =  $lr->findBy(["categorie" => "poetique"]);
        $prixPoesie =  $calculatrice->total($book);
        $book =  $lr->findBy(["categorie" => "fantastique"]);
        $prixfantastique =  $calculatrice->total($book);
        return new Response("Résultat :" .  $prixTotal . "<br>Roman :" . $prixRoman . "<br>Science :" . $prixScience."<br>Poesie :".$prixPoesie."<br>Fantastique :".$prixfantastique);
    }
}
// ####################################################################
