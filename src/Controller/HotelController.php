<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Reservation;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HotelController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private Security $security)
    {}

    #[Route('/hotel', name: 'hotels')]
    public function index(): Response
    {  
        $hotels = $this->entityManager->getRepository(Hotel::class)->findAll();

        return $this->render('hotel/index.html.twig', [
            'hotels' => $hotels
        ]);
    }

    #[Route('/hotel/{slug}', name: 'show_hotel')]
    public function show($slug, Request $request): Response
    {

        $hotel = $this->entityManager->getRepository(Hotel::class)->findOneBySlug($slug);
        
        //if slug is not found redirect on the hotels homepage
        if(!$hotel) {
            return $this->redirectToRoute('hotels');
        } 
         //get all rooms and display them in the twig template
        $rooms = $hotel->getRooms(); 
        //Booking form
        $booking = new Reservation();
        $user = $this->security->getUser();
        $form = $this->createForm(BookingType::class, $booking)->handleRequest($request);


        
/*       if($form->isSubmitted() && $form->isValid()) {

        $availableData = $this->entityManager->getRepository(Reservation::class)
            ->findAvailableRooms($booking->getCheckin(), $booking->getCheckout(), $booking->getRoomId());
    
            if (!$user) {
                return $this->redirectToRoute('app_login');
            }
            
            $booking->setCustomerId($user);
            $booking->setIsBooked(true);
            $booking->getCheckin();
            $booking->getCheckout();

            $this->entityManager->persist($user);
            $this->entityManager->persist($booking);
    
            $this->entityManager->flush(); */

/* 
        $this->addFlash('success', 'You room has been booked!');

            return $this->redirectToRoute('account');
        } else {

        }  */

        return $this->render('hotel/showhotel.html.twig', [
            'hotel' => $hotel,
            'rooms' => $rooms,
           /*  'formObject' => $form,  */ 
        ]);
    }
} 
