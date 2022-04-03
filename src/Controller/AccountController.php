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
        $date = new DateTime();
        $dateBooking = $booking->getCheckin()->modify('- 3 days');
        
        if ($dateBooking <= $date) {
            $this->addFlash('danger', 'You can\'t cancel a booking within the last 3 days');

            return $this->redirectToRoute('account');
        }
        $this->entityManager->remove($booking);
        $this->entityManager->flush();

        return $this->redirectToRoute('account');
    }

    }

