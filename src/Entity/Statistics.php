<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Filter\StatisticsFilter;


/**
 * @ApiResource(
 *      itemOperations={
 *          "get"={
 *              "method"="GET",
 *           },
 *      },
 *      collectionOperations={"get"},
 *      normalizationContext={"groups"={"search:read"}},
 *    
 * )
 * 
 * @ApiFilter(StatisticsFilter::class)
 */

class Statistics 
{
    public function __construct(int $id, int $numberOfMessages, array $groupedBy)
    {
        $this->id = $id;
        $this->groupedBy = $groupedBy;
        $this->numberOfMessages = $numberOfMessages;
    }

    /**
     * @ApiProperty(identifier=true)
     */
    public $id;

    /**
      * @Groups({"search:read"})
      * @var array
      */
    public $groupedBy;

    /**
      * @Groups({"search:read"})
      * @var int
      */
    public $numberOfMessages;
}