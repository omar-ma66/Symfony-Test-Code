<?php

namespace App\Message ;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage]
class LivreCreatedMessage
{
    public function __construct( private int $livreId)
    {
    }

    public function getLivreId(): int
    {
        return $this->livreId ;
    }
}