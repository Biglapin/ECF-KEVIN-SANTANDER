<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AccountController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private Security $security)
    {}



    #[Route('/account', name: 'account')]
    public function index(): Response
    {
        $user = new User();
        $user->getReservations();
       
        $accountHistory = $this->entityManager->getRepository(Reservation::class)->findHistory($this->getUser());
      
       // dd($accountHistory);
        //$accountHystory = $this->entityManager->getRepository(Reservation::class)->findOneBy(['user' => $this->security->getUser()]);
       
       // $booking = $user->getReservations();

        return $this->render('account/index.html.twig', [
            'accountHistory' => $accountHistory,
        ]);
    }
}
