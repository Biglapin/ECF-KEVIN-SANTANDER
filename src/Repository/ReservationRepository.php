<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,private Security $security)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Reservation $entity, bool $flush = true): void
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
    public function remove(Reservation $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function findHistory($user)
    {
        $user = $this->security->getUser();
        
        return $this->createQueryBuilder('r')
            ->where('r.customerId = :customerId')
            ->setParameter('customerId',$user)
            ->getQuery()
            ->getResult();
        ;
    }

    public function findAvailableRooms($checkin, $checkout, $room)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('r')
            ->from(Reservation::class, 'r')
            ->andWhere('r.checkin BETWEEN :checkin AND :checkout OR r.checkout BETWEEN :checkin AND :checkout OR :checkin BETWEEN r.checkin AND r.checkout')
            ->andWhere('r.roomId = :roomId')
            ->setParameter('checkin', $checkin)
            ->setParameter('checkout', $checkout)
            ->setParameter('roomId', $room)
        ;
        $result = $qb->getQuery()->getResult();

        return $result;
    } 
}
