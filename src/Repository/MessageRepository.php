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

    public function findSearch(
        string $accountName="%", 
        string $message="%", 
        string $dateFrom, 
        string $dateTo, 
        int $limit = null, 
        int $offset = null)
    {
        return $this->createQueryBuilder('m')
            ->select("m.id, a.name, m.date, m.message")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->andWhere("m.message LIKE :message")
            ->andWhere("m.date >= :dateFrom")
            ->andWhere("m.date <= :dateTo")
            ->orderBy("m.date")
            ->setParameter("account_name", "%".$accountName."%")
            ->setParameter("message", "%".$message."%")
            ->setParameter("dateFrom", $dateFrom)
            ->setParameter("dateTo", $dateTo)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSearchDateFrom(
        string $accountName="%", 
        string $message="%", 
        string $dateFrom, 
        int $limit = null, 
        int $offset = null)
    {
        return $this->createQueryBuilder('m')
            ->select("m.id, a.name, m.date, m.message")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->andWhere("m.message LIKE :message")
            ->andWhere("m.date >= :dateFrom")
            ->orderBy("m.date")
            ->setParameter("account_name", "%".$accountName."%")
            ->setParameter("message", "%".$message."%")
            ->setParameter("dateFrom", $dateFrom)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSearchDateTo(
        string $accountName="%", 
        string $message="%", 
        string $dateTo, 
        int $limit = null, 
        int $offset = null)
    {
        return $this->createQueryBuilder('m')
            ->select("m.id, a.name, m.date, m.message")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->andWhere("m.message LIKE :message")
            ->andWhere("m.date <= :dateTo")
            ->orderBy("m.date")
            ->setParameter("account_name", "%".$accountName."%")
            ->setParameter("message", "%".$message."%")
            ->setParameter("dateTo", $dateTo)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSearchNoDateParam(
        string $accountName="%", string $message="%", 
        int $limit = null, int $offset = null)
    {
        return $this->createQueryBuilder('m')
            ->select("m.id, a.name, m.date, m.message")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->andWhere("m.message LIKE :message")
            ->orderBy("m.date")
            ->setParameter("account_name", "%".$accountName."%")
            ->setParameter("message", "%".$message."%")
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findYearStatistics(string $accountName) {
        return $this->createQueryBuilder('m')
            ->select("YEAR(m.date) as date_year, count(m.id) as num")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->groupBy("date_year")
            ->orderBy("date_year")
            ->setParameter("account_name", "%".$accountName."%")
            ->getQuery()
            ->getResult()
        ;
    }

    public function findMonthStatistics(string $accountName) {
        return $this->createQueryBuilder('m')
            ->select("MONTH(m.date) as date_month, count(m.id) as num")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->groupBy("date_month")
            ->orderBy("date_month")
            ->setParameter("account_name", "%".$accountName."%")
            ->getQuery()
            ->getResult()
        ;
    }

    public function findDayStatistics(string $accountName) {
        return $this->createQueryBuilder('m')
            ->select("DAY(m.date) as date_day, count(m.id) as num")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->groupBy("date_day")
            ->orderBy("date_day")
            ->setParameter("account_name", "%".$accountName."%")
            ->getQuery()
            ->getResult()
        ;
    }

    public function findWeekdayStatistics(string $accountName) {
        return $this->createQueryBuilder('m')
            ->select("DAYOFWEEK(m.date) as date_weekday, count(m.id) as num")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->groupBy("date_weekday")
            ->orderBy("date_weekday")
            ->setParameter("account_name", "%".$accountName."%")
            ->getQuery()
            ->getResult()
        ;
    }

    public function findHourStatistics(string $accountName) {
        return $this->createQueryBuilder('m')
            ->select("HOUR(m.date) as date_hour, count(m.id) as num")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->groupBy("date_hour")
            ->orderBy("date_hour")
            ->setParameter("account_name", "%".$accountName."%")
            ->getQuery()
            ->getResult()
        ;
    }

    public function findYearMonthStatistics(string $accountName) {
        return $this->createQueryBuilder('m')
            ->select("YEAR(m.date) date_year, MONTH(m.date) date_month, count(m.id) as num")
            ->innerJoin('m.account', 'a')
            ->where("a.name LIKE :account_name")
            ->groupBy("date_year, date_month")
            ->orderBy("date_year, date_month")
            ->setParameter("account_name", "%".$accountName."%")
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
