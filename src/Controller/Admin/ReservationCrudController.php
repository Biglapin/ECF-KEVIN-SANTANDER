<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
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
    
}
