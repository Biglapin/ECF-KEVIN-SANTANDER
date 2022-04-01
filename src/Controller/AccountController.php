<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use DateTime;
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

        return $this->render('account/index.html.twig', [
            'accountHistory' => $accountHistory,
        ]);
    }
    
    #[Route('/account/{id}', name: 'cancel_book', methods: ['GET'])]
    public function cancelBooking(Reservation $booking): Response
    {
        $this->entityManager->remove($booking);
        $this->entityManager->flush();

        return $this->redirectToRoute('account');
    }

    }

