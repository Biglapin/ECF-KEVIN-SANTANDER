<?php

namespace App\Controller\Admin;

use App\Entity\Hotel;
use App\Entity\Room;
use App\Entity\User;
use App\Repository\HotelRepository;
use App\Repository\RoomRepository;
use Doctrine\DBAL\Query\QueryBuilder as QueryQueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\AST\Join as ASTJoin;
use Doctrine\ORM\Query\Expr\Join;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
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
       // $hotel = $this->hotelRepository->findOneById($hotelId);

        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        return $queryBuilder
            ->andWhere('entity.hotelId = :hotelId')
            ->setParameter('hotelId', $hotelId);
    }
    
    
    /*    public function configureCrud(Crud $crud): Crud   
    {
        return parent::configureCrud($crud)
            ->setEntityPermission('HOTEL_MANAGER_LONDON');
    }  
    */

    public static function getEntityFqcn(): string
    {
        return Room::class;
    }

    public function configureFields(string $pageName): iterable
    {        
       // $hotelRepository = $this->entityManager->getRepository(Hotel::class);
        $user = $this->security->getUser();
       // $hotel = $hotelRepository->findBy([id = $user->getHotelId()]);

        return [
            TextField::new('title', 'Title'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image')->setBasePath('/images/rooms/')->onlyOnIndex(),
            TextareaField::new('description', 'Description'),
            AssociationField::new('hotelId')->setQueryBuilder(
                fn (QueryBuilder $queryBuilder) => $queryBuilder->getEntityManager()->getRepository(Hotel::class)->findOneByHotel()),
            MoneyField::new('price')->setCurrency('EUR'),
            BooleanField::new('isAvailable', 'Available')
                ->renderAsSwitch(false), 
            SlugField::new('slug')->setTargetFieldName('title'),
            UrlField::new('link')
        ];
    }
 /*    public function updateEntity(EntityManagerInterface $entityManager, $hotelId): void
    {
        $user = $this->security->getUser();
        $hotelId = $user->getHotelId();
        $hotelId->setHotelId($hotelId->getHotelId());
        dd($hotelId);
        $entityManager->flush();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance, $user): void
    {
        $entityInstance->setHotelId($entityInstance->getHotelId($hotelId = $user->getHotelId()));
        //dd($entityInstance);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    } */
}
