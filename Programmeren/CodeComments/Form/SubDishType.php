<?php

use App\Entity\Dish;
use App\Entity\SubDish;

class SubDishType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('dish', EntityType::class, [
                'class' => Dish::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubDish::class,
        ]);
    }
}
