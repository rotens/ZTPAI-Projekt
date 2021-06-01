<?php

namespace App\Filter;

use ApiPlatform\Core\Serializer\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;

class CustomSearchFilter implements FilterInterface
{

    public function apply(Request $request, bool $normalization, array $attributes, array &$context) 
    {
        $dateFrom = $request->query->get('dateFrom');
        $dateTo = $request->query->get('dateTo');
        $accountName = $request->query->get('account_name');
        $message = $request->query->get('message');
        $page = $request->query->get('page');

        if ($dateFrom) {
            $context['search_date_from'] = $dateFrom;
        }

        if ($dateTo) {
            $context['search_date_to'] = $dateTo;
        }

        if ($accountName) {
            $context['search_account_name'] = $accountName;
        } 
 
        if ($message) {
            $context['search_message'] = $message;
        }

        if ($page) {
            $context['page'] = $page;
        }
    }
    

    public function getDescription(string $resourceClass): array
    {
        return [
            'account_name' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'description' => 'Account name',
                ],
            ],
            'dateFrom' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'description' => 'From date e.g. 2020-09-01',
                ],
            ], 
            'dateTo' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'description' => 'To date e.g. 2020-09-01',
                ],
            ],
            'message' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'description' => 'Contained message',
                ],
            ]
        ];
    }
}