<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Security;

class RoomController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer, private Security $security)
    {
        $this->serializer = $serializer;
    }

    #[Route('/room', name: 'rooms')]
    public function index(): Response
    {
        $rooms = $this->entityManager->getRepository(Room::class)->findAll();

        return $this->render('room/index.html.twig', [
            'rooms' => $rooms
        ]);
    }

    #[Route('/room/{slug}', name: 'show_room')]
    public function show($slug, Request $request): Response
    {
        $booking = new Reservation();
        $room = $this->entityManager->getRepository(Room::class)->findOneBySlug($slug);
        $booking->setRoomId($room);
        $form = $this->createForm(BookingType::class, $booking)->handleRequest($request);

        $user = $this->security->getUser();
        $booking->setCustomerId($user);
        $booking->setIsBooked(true);

        if(!$room) {
            return $this->redirectToRoute('hotels');
        }

        if($form->isSubmitted() && $form->isValid()) {
            $booking->setCustomerId($user);
            $booking->setIsBooked(true);

            $this->entityManager->persist($user);
            $this->entityManager->persist($booking);
            $this->entityManager->flush();

            $this->addFlash('success', 'You room has been booked!');

            return $this->redirectToRoute('account');
        }

        return $this->render('room/showroom.html.twig', [
            'room' => $room,
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/fetchroom', name: 'fetch_rooms', methods: ['GET'])]
    public function fetchAllRoom(Request $request): Response
    {   
        $booking = new Reservation();
        $dateCheckin = new \DateTime($request->query->get('checkin'));
        $dateCheckout = new \DateTime($request->query->get('checkout'));
        $roomId = $request->query->get('roomid');

        $suiteAvailable = $this->entityManager->getRepository(Reservation::class)->findAll();

        $data = $this->serializer->serialize($suiteAvailable, 'json', ['groups' => 'fetch_rooms']); 

        
        foreach ($suiteAvailable as $suite) {
            if(
            $roomId == $suite->getRoomId()->getId()
                && (
                    ($dateCheckin >= $suite->getCheckin() && $dateCheckin < $suite->getCheckout()) 
                    || ($dateCheckout > $suite->getCheckin() && $dateCheckout <= $suite->getCheckout()) 
                    || ($suite->getCheckin() >= $dateCheckin && $suite->getCheckin() <= $dateCheckout)
                )
            ) {
            return new JsonResponse(400); 
        } 
    }
    return new JsonResponse(200);

        $response = new Response($data, 200, [
            'Content-Type', 'application/json'
        ]); 

        return $response;  
    }
}


