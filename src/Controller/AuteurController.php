<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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
    #[IsGranted('ROLE_USER')]
   public function  create(EntityManagerInterface $em,Request $request):Response
   {
      $auteur = new Auteur();
      $form = $this->createForm(AuteurType::class ,$auteur);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($auteur);
            $em->flush();
                            $this->addFlash('success',"l'auteur a bien été créer");

            return $this->redirectToRoute('app_auteur_liste');
        }
        return $this->render('auteur/create.html.twig',[
            'form'=>$form
            ]);

   }

   #[Route('/auteur/delete/{id}',name:'app_auteur_delete',methods:['POST'],requirements:['id'=> Requirement::DIGITS])]
    #[IsGranted('ROLE_ADMIN')]
  
   public function delete(Auteur $auteur,EntityManagerInterface $em ,Request $request,AuteurRepository $ar)
   {
    
        if($this->isCsrfTokenValid('delete'.$auteur->getId() ,$request->request->get('_token')))
            {
                $em->remove($auteur);
                $em->flush();
               $this->addFlash('success',"l'auteur a bien été supprimé ");

                return $this->redirectToRoute('app_auteur_liste');
            }

    return $this->render('auteur/liste.html.twig',['auteur'=>$ar->findAll()]);

   }
// ##########################################################################################
        #[Route('/auteur/edite/{id}',name:'app_auteur_update',methods:['GET','POST'])]
        #[IsGranted('ROLE_USER')]

        public function update(Auteur $auteur ,EntityManagerInterface $em ,Request $request):Response
        {

                $form = $this->createForm(AuteurType::class,$auteur);
                $form->handleRequest($request);

                    if($form->isSubmitted() && $form->isValid())
                        {
                            $em->flush();
                            $this->addFlash('success','votre mise a jour est actualisé');
                            // return $this->redirectToRoute('app_auteur_liste',[],Response::HTTP_SEE_OTHER);
                            return $this->redirectToRoute('app_auteur_liste');
                        }
                   


            return $this->render('auteur/update.html.twig',['form'=>$form->createView()]);
        }
}
