<?php

namespace App\Controller;

use App\Form\UploadType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class UploadController extends AbstractController
{
    #[Route('/upload', name: 'app_upload')]
    public function index(Request $request,SluggerInterface $slugger): Response
    {

$form = $this->createForm(UploadType::class) ;
    $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
                {
                    $fichier = $form->get('Brochure')->getData();
                    // $fichier est un objet de type UploadFile ou null
                    if($fichier)
                        {
                      //      dd( $slugger->slug( pathinfo($fichier->getClientOriginalName(),PATHINFO_FILENAME)) );
                            $monFichier = uniqid().'.'.$fichier->guessExtension();
                            $fichier->move($this->getParameter('brochures_directory'),$monFichier);
                            $this->addFlash("success","votre fichier a bien été téléchargé !");
                            $this->redirectToRoute('app_upload');
                        }
                }

        return $this->render('upload/index.html.twig', [
            'form' => $form
        ]);
    }
}
