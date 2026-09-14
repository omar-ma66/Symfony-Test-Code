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
#[Route('/livre')]
final class LivreController extends AbstractController
{
    #[Route('/', name: 'app_livre',methods:['GET'])]
    public function index(LivreRepository $livre): Response
    {
      $all =    $livre->findAll();
        return $this->render('livre/index2.html.twig', [
            "livres"=>$all
        ]);
    }
// ####################################################################

    #[Route('/new',name: 'app_livre_create',methods:['GET','POST'])]
    public function create(Request $request,EntityManagerInterface $em ): Response
    {
            $livre = new Livre();
            $form = $this->createForm(LivreType::class,$livre) ;

            $form->handleRequest($request) ;
            if($form->isSubmitted() && $form->isValid())
                {
                    $em->persist($livre);
                    $em->flush();

                    return $this->redirectToRoute("app_livre");
                }

   return   $this->render("livre/create.html.twig",
      [
        "form"=>$form
        ]);
    }

// ####################################################################


#[Route('/supprime/{id}',name:'app_livre_delete',methods:['POST'] ,requirements :['id' =>Requirement::DIGITS])]
public function delete(Request $request ,EntityManagerInterface $em,Livre $livre):Response
{
  
if($this->isCsrfTokenValid('delete' . $livre->getId() ,(string) $request->request->get('_token')))
    {
        $em->remove($livre);
        
        $em->flush();
    }
    return $this->redirectToRoute('app_livre');
} 

// ####################################################################
#[Route('/update/{id}',name: 'app_livre_update',methods:['GET','POST'],requirements:['id' => Requirement::DIGITS])]
public function update(Request $request,Livre $livre ,EntityManagerInterface $em):Response
{

$tableau = ["un","deux","trois","quatre","cinq","six","sept","huit","neuf","dix"];


  $form = $this->createForm(LivreType::class , $livre);
  $form->handleRequest($request);
if($form->isSubmitted() && $form->isValid())
    {
        $em->flush();
      return  $this->redirectToRoute('app_livre',[],Response::HTTP_SEE_OTHER);
    }
  return $this->render('livre/update.html.twig',["form"=>$form,"livre"=>$livre,"tableau"=>$tableau]);         
}
// ####################################################################
}
// ####################################################################
