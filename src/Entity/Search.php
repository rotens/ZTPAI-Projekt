<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Filter\CustomSearchFilter;

/**
 * @ApiResource(
 *      itemOperations={
 *          "get"={
 *              "method"="GET",
 *              
 *           },
 *      },
 *      collectionOperations={"get"},
 *      normalizationContext={"groups"={"search:read"}},
 *      paginationItemsPerPage=5,
 *    
 * )
 *
 * @ApiFilter(CustomSearchFilter::class)
 */

class Search 
{

    public function __construct(int $id, string $account_name, \DateTimeInterface $date, string $message)
    {
        $this->id = $id;
        $this->account_name = $account_name;
        $this->date = $date;
        $this->message = $message;
    }

    /**
     * @ApiProperty(identifier=true)
     */
    public $id;

    /**
      * @Groups({"search:read"})
      * @var string
      */
    public $account_name;

    /**
      * @Groups({"search:read"})
      * @var \DateTimeInterface
      */
    public $date;

    /**
      * @Groups({"search:read"})
      * @var string
      */
    public $message;
}