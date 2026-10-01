<?php

namespace App\Event;

use App\Entity\Livre;

class LivreCreatedEvent
{
            public function __construct(private Livre $livre)
            {   
            }

            public function getLivre(): Livre
            {
                return $this->livre ;
            }
}