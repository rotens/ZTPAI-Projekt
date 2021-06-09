<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\Pagination;
use Symfony\Component\Security\Core\Security;
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
    private $security;

    public function __construct(ManagerRegistry $managerRegistry, Pagination $pagination, Security $security)
    {
      $this->managerRegistry = $managerRegistry;
      $this->pagination = $pagination;
      $this->security = $security;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        list($page, $offset, $limit) = $this->pagination->getPagination($resourceClass, $operationName);

        $manager = $this->managerRegistry->getManagerForClass(Message::class);
        $repository = $manager->getRepository(Message::class);

        $user = $this->security->getUser();
        if ($user->getRoles() != ["ROLE_FULL"]) {
            $dateFrom = $user->getJoinDate()->format('Y-m-d H:i:s');
        } else {
            $dateFrom = $context['search_date_from'] ?? '';
        }
        
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