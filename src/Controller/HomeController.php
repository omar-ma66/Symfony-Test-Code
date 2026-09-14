<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(#[Autowire(env: "MACLEF_TEST")] string $maClef): Response
    {

            return $this->json(["cles_env" => $maClef]);
    }

    #[Route('/code', name: 'app_code')]
     public function index2(): Response
    {

    $maClef = $this->getParameter("app.ma_super_cle");
            return $this->json(["cles_env" => $maClef]);
      
    }




}
