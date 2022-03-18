<?php

namespace App\Security\Voter;

use App\Entity\Room;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminUserVoter extends Voter
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, ['HOTEL_MANAGER_LONDON'])
            && $subject instanceof Room;
            
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
       // dd($attribute);
        if(!$subject instanceof Room ) {
            throw new \LogicException('Subject is not an instance of User?');
        }  


        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'HOTEL_MANAGER_LONDON':
               // dd($subject);
                return $user === $subject || $this->security->isGranted('ROLE_SUPER_ADMIN');
        }

        return false;
    }
 
}
