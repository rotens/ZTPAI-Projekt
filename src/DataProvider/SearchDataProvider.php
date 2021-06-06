<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\Pagination;
use App\DataProvider\SearchPaginator;
use App\Repository\MessageRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Search;
use App\Entity\Message;
use DateTime;

class SearchDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{

    private $managerRegistry;
    private $pagination;

    public function __construct(ManagerRegistry $managerRegistry, Pagination $pagination)
    {
      $this->managerRegistry = $managerRegistry;
      $this->pagination = $pagination;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
       
        list($page, $offset, $limit) = $this->pagination->getPagination($resourceClass, $operationName);

        $manager = $this->managerRegistry->getManagerForClass(Message::class);
        $repository = $manager->getRepository(Message::class);

        $dateFrom = $context['search_date_from'] ?? '';
        $dateTo = $context['search_date_to'] ?? '';
        $accountName = $context['search_account_name'] ?? "%";
        $message = $context['search_message'] ?? "%";
        $page = $context['page'] ?? 1;
        
        $paginator = new SearchPaginator($repository, $page, $limit);
        $paginator->setDateFrom($dateFrom);
        $paginator->setDateTo($dateTo);
        $paginator->setAccountName($accountName);
        $paginator->setMessage($message);

        return $paginator;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Search::class;
    }
}