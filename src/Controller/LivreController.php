<?php

namespace App\Controller;
use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Requirement\Requirement;

// ####################################################################
final class LivreController extends AbstractController
{
    #[Route('/livre', name: 'app_livre')]
    public function index(LivreRepository $livre): Response
    {
      $all =    $livre->findAll();
        return $this->render('livre/index2.html.twig', [
            'controller_name' => 'LivreController',"livres"=>$all
        ]);
    }
// ####################################################################

    #[Route('/livre/new',name: 'app_livre_create')]
    public function create(Request $request,EntityManagerInterface $em ): Response
    {
            $livre = new Livre();

            $form = $this->createForm(LivreType::class,$livre) ;

            $form->handleRequest($request) ;
            if($form->isSubmitted() && $form->isValid())
                {
                    $em->persist($livre);
                    $em->flush();

                    return $this->redirectToRoute("app_livre_create");
                }

   return   $this->render("livre/create.html.twig",
      [
        "form"=>$form
        ]);
    }

// ####################################################################


#[Route('/livre/supprime/{id}',name:'app_livre_delete',methods:['POST'])]
public function delete(Request $request ,EntityManagerInterface $em,Livre $livre):Response
{
  
if($this->isCsrfTokenValid('delete' . $livre->getId() ,$request->request->get('_token')))
    {
        $em->remove($livre);
        
        $em->flush();
    }
    return $this->redirectToRoute('app_livre');
} 

// ####################################################################
#[Route('/livre/update/{id}',name: 'app_livre_update',methods:['GET','POST'],requirements:['id' => Requirement::DIGITS])]
public function update(Request $request,Livre $livre ,EntityManagerInterface $em):Response
{
  $form = $this->createForm(LivreType::class , $livre);
  $form->handleRequest($request);
  if($form->isSubmitted() && $form->isValid())
    {
        $em->flush();
      return  $this->redirectToRoute('app_livre');
    }
 return $this->render('livre/index2.html.twig',["form"=>$form,"livre"=>$livre]);         
}



// ####################################################################
}
// ####################################################################
