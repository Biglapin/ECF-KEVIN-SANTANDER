<?php

namespace App\Repository;

use App\Entity\Hotel;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Hotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotel[]    findAll()
 * @method Hotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelRepository extends ServiceEntityRepository
{   
    private $security;
    public function __construct(ManagerRegistry $registry,Security $security)
    {
        parent::__construct($registry, Hotel::class);
        $this->security = $security;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Hotel $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Hotel $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findOneByHotel()
    {
        $user = $this->security->getUser()->getHotelId();
        return $this->createQueryBuilder('h')
            ->where('h.id = :id')
            ->setParameter('id',$user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

/*     /**
    * @return Hotel[] Returns an array of Room objects
    */  
/*     public function findByManager()
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.id = :id')
            ->setParameter('id', '1')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    } */
}
