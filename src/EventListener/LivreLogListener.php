<?php

namespace App\EventListener;

use App\Entity\Livre;
use App\Event\LivreCreatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Contracts\EventDispatcher\Event;

#[AsEventListener(event: LivreCreatedEvent::class ,priority : 10)]

class LivreLogListener
{
    public function __invoke(LivreCreatedEvent $event): void
    {

        $livre = $event->getLivre();
        dump('LOG : livre créé = ' . $livre->getTitre());
    }
}
