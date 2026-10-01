<?php

namespace App\Security\Voter;

use App\Entity\Livre;
use App\Entity\User;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;

final class LivreVoter extends Voter
{
    public function __construct(private Security $security) {}

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, ['EDIT', 'DELETE', 'VIEW'], true) && $subject instanceof Livre;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }
        $livre = $subject;
        //$roles = $user->getRoles();
        // in_array('ROLE_ADMIN',$role,true);
        return $user->getId() === $livre->getUser()->getId() || $this->security->isGranted('ROLE_ADMIN');
    }
}
