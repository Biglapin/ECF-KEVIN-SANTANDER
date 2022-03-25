<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('roomId', 'Room'),
            AssociationField::new('customerId', 'Customer Name'),
            DateField::new('checkin', 'Check-in'),
            DateField::new('checkout', 'Check-out'),
            DateField::new('created_at'),
        ];
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $dateCreateAt = new DateTime();

        $entityManager->persist($dateCreateAt);
        $entityManager->flush();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityManager->flush();
    }
}
