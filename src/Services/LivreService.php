<?php

namespace App\Services;

use App\Repository\LivreRepository;

class LivreService
{
  public function __construct(private LivreRepository $livreRepository) {}

  public function getLivres(): array
  {
    return $this->livreRepository->findAll();
  }
}
