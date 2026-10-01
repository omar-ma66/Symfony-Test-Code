<?php
namespace App\EventListener;


use App\Event\LivreCreatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: LivreCreatedEvent::class)]
class LivreCreatedListener
{

public function __invoke( LivreCreatedEvent $event) :void
{
    $livre =$event->getLivre();
    dump($livre->getTitre());
}
}



