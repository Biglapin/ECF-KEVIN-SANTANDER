<?php

namespace App\Controller;

use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RoomController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {}

    #[Route('/room', name: 'rooms')]
    public function index(): Response
    {
        $rooms = $this->entityManager->getRepository(Room::class)->findAll();

        return $this->render('room/index.html.twig', [
            'rooms' => $rooms
        ]);
    }

    #[Route('/room/{slug}', name: 'show_room')]
    public function show($slug): Response
    {
        $room = $this->entityManager->getRepository(Room::class)->findOneBySlug($slug);
        
        if(!$room) {
            return $this->redirectToRoute('hotels');
        }

        return $this->render('room/showroom.html.twig', [
            'room' => $room
        ]);
    }

}
