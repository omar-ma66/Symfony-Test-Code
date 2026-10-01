<?php

namespace App\Services;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Psr\EventDispatcher\EventDispatcherInterface;

class LivreService
{
  public function __construct(private LivreRepository $livreRepository ,private EventDispatcherInterface $dispatcher) {}

  public function getLivres(): array
  {
    return $this->livreRepository->findAll();
  }

  public function getMessage():string
  {
    return "bonjour depuis LivreService" ;
  }

  public function ceerLivre(Livre $livre)
  {
      $this->livreRepository->save($livre,true);
  }
}
