<?php

namespace App\Filter;

use ApiPlatform\Core\Serializer\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;

class StatisticsFilter implements FilterInterface
{

    public function apply(Request $request, bool $normalization, array $attributes, array &$context) 
    {
        $accountName = $request->query->get('account_name');
        $groupBy = $request->query->get('groupby');

        if ($accountName) {
            $context['search_account_name'] = $accountName;
        } 

        if ($groupBy) {
            $context['search_group_by'] = $groupBy;
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
            'groupby' => [
                'property' => null,
                'type' => 'string',
                'required' => true,
                'openapi' => [
                    'description' => 'Group by',
                ],
            ]
            
        ];
    }
}