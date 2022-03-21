<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Room;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
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
        //get all rooms and display them in the twig template with a foreach. 
        $rooms = $hotel->getRooms();

        //Booking form

        $room = new Room();
        $form = $this->createForm(BookingType::class)->handleRequest($request);
        
            
    

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            dd($data);


        /*     $this->entityManager->persist($data);
            $this->entityManager->flush(); */


        $this->addFlash('success', 'Booking ok');

            return $this->redirectToRoute('/');
        } else {

        }

        return $this->render('hotel/showhotel.html.twig', [
            'hotel' => $hotel,
            'rooms' => $rooms,
            'formObject' => $form
        ]);
    }
} 
