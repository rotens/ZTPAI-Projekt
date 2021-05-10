<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => Account::class,
                'choice_label' => 'name',
            ])
            ->add('from_date', DateType::class)
            ->add('to_date', DateType::class)
            ->add('search_input', TextType::class)
            ->add('search', SubmitType::class)
        ;
    }
}
