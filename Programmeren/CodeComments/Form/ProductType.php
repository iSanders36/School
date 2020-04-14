<?php

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\SubDish;

class ProductType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "attr" => [ "class" => "input" ],
                "label" => "Product naam"
            ])
            ->add('price', NumberType::class, [
                "attr" => [ "class" => "input" ],
                "label" => "Prijs in euro's"
            ])
            ->add('SubDish', EntityType::class, [
                'class' => SubDish::class,
                'choice_label' => 'name',
                "attr" => [ "class" => "input" ],
                "label" => "Sub gerecht"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
