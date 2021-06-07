<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\Pagination;
use App\Repository\MessageRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Statistics;
use App\Entity\Message;

class StatisticsDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $managerRegistry;
    private $pagination;
    private $repository;

    public function __construct(ManagerRegistry $managerRegistry, Pagination $pagination)
    {
      $this->managerRegistry = $managerRegistry;
      $this->pagination = $pagination;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $manager = $this->managerRegistry->getManagerForClass(Message::class);
        $this->repository = $manager->getRepository(Message::class);

        $accountName = $context['search_account_name'] ?? "%";
        $groupBy = $context['search_group_by'] ?? "year";

        $results = $this->getResults($accountName, $groupBy);

        return $results;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Statistics::class;
    }

    private function getResults(string $accountName, string $groupBy) {
        $objects = [];

        if ($groupBy == "year") {
            $results = $this->repository->findYearStatistics($accountName);
            
            $i = 1;
            foreach ($results as $row) {
                $objects[] = new Statistics(
                    $i++,
                    $row['num'],
                    [ $row['date_year'] ],
                );
            }


            return $objects;
        }

        if ($groupBy == "month") {
            $results = $this->repository->findMonthStatistics($accountName);

            $i = 1;
            foreach ($results as $row) {
                $objects[] = new Statistics(
                    $i++,
                    $row['num'],
                    [ $row['date_month'] ],
                );
            }

            return $objects;
        }

        if ($groupBy == "day") {
            $results = $this->repository->findDayStatistics($accountName);

            $i = 1;
            foreach ($results as $row) {
                $objects[] = new Statistics(
                    $i++,
                    $row['num'],
                    [ $row['date_day'] ],
                    
                );
            }

            return $objects;
        }

        if ($groupBy == "weekday") {
            $results = $this->repository->findWeekdayStatistics($accountName);

            $i = 1;
            foreach ($results as $row) {
                $objects[] = new Statistics(
                    $i++,
                    $row['num'],
                    [ $row['date_weekday'] ],
                );
            }

            return $objects;
        }

        if ($groupBy == "hour") {
            $results = $this->repository->findHourStatistics($accountName);

            $i = 1;
            foreach ($results as $row) {
                $objects[] = new Statistics(
                    $i++,
                    $row['num'],
                    [ $row['date_hour'] ],
                    
                );
            }

            return $objects;
        }

        if ($groupBy == "year_month") {
            $results = $this->repository->findYearMonthStatistics($accountName);

            $i = 1;
            foreach ($results as $row) {
                $objects[] = new Statistics(
                    $i++,
                    $row['num'],
                    [ $row['date_year'], $row['date_month'] ],
                );
            }

            return $objects;
        }
        
        return [];
    }

    // private function createObjects(array $results, array $keys) {
    //     $objects = [];

    //     $i = 1;
    //     foreach ($results as $row) {
           
    //     } 
        

    // }
}

