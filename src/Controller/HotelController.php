<?php

namespace App\Controller;

use App\Entity\Hotel;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function show($slug): Response
    {
        $hotel = $this->entityManager->getRepository(Hotel::class)->findOneBySlug($slug);
        
        if(!$hotel) {
            return $this->redirectToRoute('hotels');
        }

        return $this->render('hotel/showhotel.html.twig', [
            'hotel' => $hotel
        ]);
    }
}
