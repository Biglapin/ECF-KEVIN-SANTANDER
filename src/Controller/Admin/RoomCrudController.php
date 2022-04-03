<?php

namespace App\Controller\Admin;

use App\Entity\Hotel;
use App\Entity\Room;
use App\Entity\User;
use App\Repository\HotelRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Security\Core\Security;

class RoomCrudController extends AbstractCrudController
{
    public function __construct(RoomRepository $roomRepository, Security $security, HotelRepository $hotelRepository, EntityManagerInterface $entityManager)
    {
        $this->roomRepository = $roomRepository;
        $this->security = $security;
        $this->hotelRepository = $hotelRepository;
        $this->entityManager = $entityManager;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $user = $this->security->getUser();

        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return $queryBuilder;
    
        }
        
    return $this->createIndexQueryBuilderForManager($searchDto,  $entityDto, $fields, $filters, $user);
    }

    public function createIndexQueryBuilderForManager(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters, $user): QueryBuilder
    {
        $hotelId = $user->getHotelId();

        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        return $queryBuilder
            ->andWhere('entity.hotelId = :hotelId')
            ->setParameter('hotelId', $hotelId);
    }
    
    public static function getEntityFqcn(): string
    {
        return Room::class;
    }

    public function configureFields(string $pageName): iterable
    {        
    /** @var User $user */
    $user = $this->security->getUser();
    $hotel = $user->getHotelId();

        return [
            TextField::new('title', 'Title'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image')->setBasePath('/images/rooms/')->onlyOnIndex(),
            TextField::new('secondImageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('secondImage')->setBasePath('/images/rooms/')->onlyOnIndex(),
            TextareaField::new('description', 'Description'),
            AssociationField::new('hotelId')->setQueryBuilder(function(QueryBuilder $qb) use ($hotel){
                if ($this->isGranted('ROLE_SUPER_ADMIN')) {
                    return $qb;
                } else {
                    $qb
                    ->andWhere('entity = :hotel') 
                    ->setParameter('hotel', $hotel)
                    ;
                }
                return $qb;

            }
        ),
            MoneyField::new('price')->setCurrency('EUR'),
            BooleanField::new('isAvailable', 'Available')
                ->renderAsSwitch(false), 
            SlugField::new('slug')->setTargetFieldName('title'),
            UrlField::new('link')
        ];
        
    }
}
