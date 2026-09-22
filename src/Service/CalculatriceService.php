<?php

namespace App\Service;

use App\Entity\Livre;

class CalculatriceService
{
    public function additionner(float $a, float $b): float
    {
        return $a + $b;
    }

    public function soustraire(float $a, float $b): float
    {
        return $a - $b;
    }

   
    public function multiplier(float $a, float $b): float
    {
        return $a * $b;
    }
    /**
     *  @var Livre[] $livres
     */
    public function total( array  $livres):?float
    {
   $somme = 0.0 ;
     foreach($livres as $livre)
        {
  $somme += (float) $livre->getPrix();
        } 
return $somme ;
    }
}