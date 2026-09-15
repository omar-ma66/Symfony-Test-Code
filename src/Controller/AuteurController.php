<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Override;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\CssSelector\Node\MatchingNode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Throwable;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class AuteurController extends AbstractController
{

// ##########################################################################################
    #[Route('/auteur', name: 'app_auteur')]
    public function index(): Response
    {
        return $this->render('auteur/index.html.twig', [
            'controller_name' => 'AuteurController',
        ]);
    }
// ##########################################################################################
    #[Route('/auteur/liste' ,name:'app_auteur_liste',methods:['GET'])]
    public function liste(AuteurRepository $ar):Response
    {
$all = $ar->findAll();

            return $this->render('auteur/liste.html.twig',["auteurs" => $all]);
    }
// ##########################################################################################
    #[Route('/auteur/nouveau',name:'app_auteur_new',methods:['GET','POST'])]
   public function  create(EntityManagerInterface $em,Request $request):Response
   {
      $auteur = new Auteur();
      $form = $this->createForm(AuteurType::class ,$auteur);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($auteur);
            $em->flush();
            return $this->redirectToRoute('app_auteur');
        }
        return $this->render('auteur/create.html.twig',[
            'form'=>$form
            ]);

   }

   #[Route('/auteur/delete/{id}',name:'app_auteur_delete',methods:['POST'],requirements:['id'=> Requirement::DIGITS])]
   public function delete(Auteur $auteur,EntityManagerInterface $em ,Request $request)
   {
    
        if($this->isCsrfTokenValid('delete'.$auteur->getId() ,$request->request->get('_token')))
            {
                $em->remove($auteur);
                $em->flush();
                return $this->redirectToRoute('app_auteur');
            }

    return $this->render('auteur/liste.html.twig');

   }
// ##########################################################################################
        #[Route('/auteur/edite/{id}',name:'app_auteur_update',methods:['GET','POST'])]
        public function update(Auteur $auteur ,EntityManagerInterface $em ,Request $request):Response
        {

                $form = $this->createForm(AuteurType::class,$auteur);
                $form->handleRequest($request);

                    if($form->isSubmitted() && $form->isValid())
                        {
                            $em->flush();
                            return $this->redirectToRoute('app_auteur_liste');
                        }


            return $this->render('auteur/update.html.twig',['form'=>$form]);
        }
}
