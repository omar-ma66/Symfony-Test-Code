<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final class GetLivreCherController extends AbstractController
{
    public function __construct( private SerializerInterface $si, private EntityManagerInterface $entityManager,private LivreRepository $lr)
    {
    }
    public function __invoke(float $prix):JsonResponse
    {
    $books = $this->lr->getLivreCher($prix);
    $jsonContent = $this->si->serialize($books, 'json', ['groups' => 'livre:read']);
    return new JsonResponse($jsonContent, Response::HTTP_OK, [], true);
    // return ($books) ;
    
    }
}
