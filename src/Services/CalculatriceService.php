<?php

namespace App\Services;

use App\Entity\Livre;

class CalculatriceService
{

public function __construct(private string $monApplication)
{
    
}

    public function additionner(float $a, float $b): string
    {
        return $a + $b ." ".$this->monApplication;
    }

    public function soustraire(float $a, float $b ): string
    {
        return $a - $b ." ".$this->monApplication ;
    }

   
    public function multiplier(float $a, float $b): string
    {
        return $a * $b ." ".$this->monApplication ;
    }
    /**
     *  @param  Livre[] $livres
     */
    public function total( array  $livres ): string
    {
   $somme = 0.0 ;
     foreach($livres as $livre)
        {
  $somme += (float) $livre->getPrix();
        } 
return $somme ." ". $this->monApplication;
    }
}