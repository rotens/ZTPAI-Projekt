<?php

namespace App\Controller;

use App\Entity\Account;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    public function search(Request $request): Response
    {
        $defaultData = ['message' => 'Default message'];

        $form = $this->createFormBuilder($defaultData)
            ->add('user', EntityType::class, [
                'class' => Account::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'user-select'
                ],
                'label' => false
            ])
            ->add('start_date', TextType::class)
            ->add('end_date', TextType::class)
            ->add('search_input', TextType::class)
            ->add('search', SubmitType::class, array(
                'label' => false,
                'attr' => array(
                    'value' => ''
                )
            )) 
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            echo "test";
        }

        return $this->render('search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}