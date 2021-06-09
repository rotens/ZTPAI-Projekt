<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use App\Entity\Account;

class StatisticsController extends AbstractController
{
    public function statistics(): Response
    {

        $defaultData = ['message' => 'Default message'];

        $results = $this->getDoctrine()
            ->getRepository(Account::class)
            ->findAll();

        $accountNames["*"] = "";
        foreach($results as $account) {
            $accountNames[$account->getName()] = $account->getName();
        }

        $groupBy = [
            "Rok" => "year",
            "Miesiąc" => "month",
            "Dzień" => "day",
            "Dzień tygodnia" => "weekday",
            "Godzina" => "hour",
            "Rok Miesiąc" => "year_month",
        ];

        $form = $this->createFormBuilder($defaultData)
            ->add('user', ChoiceType::class, [
                'choices' => $accountNames,
                'attr' => [
                    'class' => 'user-select'
                ],
                'label' => false,
                'required' => false
            ])
            ->add('groupby', ChoiceType::class, [
                'choices' => $groupBy,
                'attr' => [
                    'class' => 'groupby-select'
                ],
                'label' => false,
                'required' => true
            ])
            ->add('generate', ButtonType::class, [
                'label' => false,
                'attr' => array(
                    'value' => ''
                )
            ]) 
            ->getForm();

        return $this->render('statistics.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}