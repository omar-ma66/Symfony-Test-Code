<?php
namespace App\MessageHandler;

use App\Message\LivreCreatedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]

class LivreCreatedMessageHandler
{
 public function __invoke( LivreCreatedMessage $message): void
{
    dump('livre reçu: '.$message->getLivreId());
}
}