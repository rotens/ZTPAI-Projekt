<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\PaginatorInterface;
use App\Repository\MessageRepository;
use App\Entity\Search;

class SearchPaginator implements PaginatorInterface, \IteratorAggregate
{

    private $searchIterator;
    private $messageRepository;
    private $currentPage;
    private $maxResults;
    private $totalItems;

    /**
     * @var string|null
     */
    private $accountName;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @var string|null
     */
    private $dateFrom;

    /**
     * @var string|null
     */
    private $dateTo;


    public function __construct(MessageRepository $messageRepository, int $currentPage, int $maxResults)
    {
        $this->messageRepository = $messageRepository;
        $this->currentPage = $currentPage;
        $this->maxResults = $maxResults;
    }

    public function setAccountName(string $accountName) 
    {
        $this->accountName = $accountName;
    }

    public function setMessage(string $message) 
    {
        $this->message = $message;
    }

    public function setDateFrom(string $dateFrom) 
    {
        $this->dateFrom = $dateFrom;
    }

    public function setDateTo(string $dateTo) 
    {
        $this->dateTo = $dateTo;
    }

    public function getLastPage(): float
    {
        return ceil($this->getTotalItems() / $this->getItemsPerPage()) ?: 1.;
    }

    public function getTotalItems(): float
    {
        return $this->totalItems;
    }

    public function getCurrentPage(): float
    {
        return $this->currentPage;
    }

    public function getItemsPerPage(): float
    {
        return $this->maxResults;
    }

    public function count()
    {
        return iterator_count($this->getIterator());
    }

    public function getResult(): array
    {
        $result = [];
        $offset = (($this->getCurrentPage() - 1) * $this->getItemsPerPage());

        if ($this->dateFrom && $this->dateTo) {
            $result = $this->messageRepository->findSearch(
                $this->accountName,
                $this->message,
                $this->dateFrom,
                $this->dateTo,
                $this->getItemsPerPage(),
                $offset
            );

            $this->totalItems = count(
                $this->messageRepository->findSearch(
                    $this->accountName,
                    $this->message,
                    $this->dateFrom,
                    $this->dateTo
                )
            );

            return $result;
        }

        if ($this->dateFrom) {
            $result = $this->messageRepository->findSearchDateFrom(
                $this->accountName,
                $this->message,
                $this->dateFrom,
                $this->getItemsPerPage(),
                $offset
            );

            $this->totalItems = count(
                $this->messageRepository->findSearchDateFrom(
                    $this->accountName,
                    $this->message,
                    $this->dateFrom
                )
            );

            return $result;
        }

        if ($this->dateTo) {
            $result = $this->messageRepository->findSearchDateTo(
                $this->accountName,
                $this->message,
                $this->dateTo,
                $this->getItemsPerPage(),
                $offset
            );

            $this->totalItems = count(
                $this->messageRepository->findSearchDateTo(
                    $this->accountName,
                    $this->message,
                    $this->dateTo
                )
            );

            return $result;
        }

        $result = $this->messageRepository->findSearchNoDateParam(
            $this->accountName,
            $this->message,
            $this->getItemsPerPage(),
            $offset
        );

        $this->totalItems = count(
            $this->messageRepository->findSearchNoDateParam(
                $this->accountName,
                $this->message
            )
        );

        return $result;
    }

    public function getIterator()
    {
        if ($this->searchIterator === null) {

            $result = $this->getResult();
            $objects = [];

            foreach($result as $obj) {
                $objects[] = new Search(
                    $obj['id'],
                    $obj['name'],
                    $obj['date'],
                    $obj['message']
                );
            }

            $this->searchIterator = new \ArrayIterator($objects);
        }

        return $this->searchIterator;
    }
}