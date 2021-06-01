<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findAllLimit(int $limit = null, int $offset = null)
    {
        return $this->createQueryBuilder('m')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSearch(string $account_name="%", string $message="%", string $dateFrom, string $dateTo, int $limit = null, int $offset = null)
    {
        return $this->createQueryBuilder('m')
            ->select("m.id, a.name, m.date, m.message")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->andWhere("m.message LIKE :message")
            ->andWhere("m.date >= :dateFrom")
            ->andWhere("m.date <= :dateTo")
            ->setParameter("account_name", "%".$account_name."%")
            ->setParameter("message", "%".$message."%")
            ->setParameter("dateFrom", $dateFrom)
            ->setParameter("dateTo", $dateTo)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSearchDateFrom(string $account_name="%", string $message="%", string $dateFrom, int $limit = null, int $offset = null)
    {
        return $this->createQueryBuilder('m')
            ->select("m.id, a.name, m.date, m.message")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->andWhere("m.message LIKE :message")
            ->andWhere("m.date >= :dateFrom")
            ->setParameter("account_name", "%".$account_name."%")
            ->setParameter("message", "%".$message."%")
            ->setParameter("dateFrom", $dateFrom)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSearchDateTo(string $account_name="%", string $message="%", string $dateTo, int $limit = null, int $offset = null)
    {
        return $this->createQueryBuilder('m')
            ->select("m.id, a.name, m.date, m.message")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->andWhere("m.message LIKE :message")
            ->andWhere("m.date <= :dateTo")
            ->setParameter("account_name", "%".$account_name."%")
            ->setParameter("message", "%".$message."%")
            ->setParameter("dateTo", $dateTo)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSearchNoDateParam(string $account_name="%", string $message="%", int $limit = null, int $offset = null)
    {
        return $this->createQueryBuilder('m')
            ->select("m.id, a.name, m.date, m.message")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->andWhere("m.message LIKE :message")
            ->setParameter("account_name", "%".$account_name."%")
            ->setParameter("message", "%".$message."%")
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
