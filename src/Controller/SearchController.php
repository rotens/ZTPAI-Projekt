<?php

namespace App\Controller;

use App\Entity\Account;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class SearchController extends AbstractController
{
    public function search(Request $request): Response
    {
        $defaultData = ['message' => 'Default message'];

        $results = $this->getDoctrine()
            ->getRepository(Account::class)
            ->findAll();

        $accountNames["*"] = "";
        foreach($results as $account) {
            $accountNames[$account->getName()] = $account->getName();
        }


        $form = $this->createFormBuilder($defaultData)
            ->add('user', ChoiceType::class, [
                'choices' => $accountNames,
                'attr' => [
                    'class' => 'user-select'
                ],
                'label' => false,
                'required' => false
            ])
            ->add('start_date', TextType::class, [
                'required' => false
            ])
            ->add('end_date', TextType::class, [
                'required' => false
            ])
            ->add('search_input', TextType::class, [
                'required' => false
            ])
            ->add('search', ButtonType::class, [
                'label' => false,
                'attr' => array(
                    'value' => ''
                )
            ]) 
            ->getForm();

        return $this->render('search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}