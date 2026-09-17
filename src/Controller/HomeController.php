<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
final class HomeController extends AbstractController
{
//     #[Route('/home', name: 'app_home')]
//     public function index(#[Autowire(env: "MACLEF_TEST")] string $maClef): Response
//     {

//             return $this->json(["cles_env" => $maClef]);
//     }

//     #[Route('/code', name: 'app_code')]
//      public function index2(): Response
//     {

//     $maClef = $this->getParameter("app.ma_super_cle");
//             return $this->json(["cles_env" => $maClef]);
      
//     }

 #[Route('/home',name:'app_home',methods:['GET'])]
 public function home():Response
 {
                return $this->render('home/index.html.twig');
 }

  #[Route('/home/test',name:'app_home_test',methods:['GET'])]
 public function test():Response
 {
                return $this->render('home/home-test.html.twig');
 }

}
