<?php

use App\Entity\Customer;
use App\Entity\Reservation;

class ReservationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('TableId', NumberType::class, [
                'attr' => [ "class" => "input" ],
                "label" => "Tafelnummer"
            ])
            ->add('date', DateTimeType::class, [
                'attr' => [ "class" => "input" ],
                "label" => "Datum en Tijd"
            ])
            ->add('count', null, [
                'attr' => [ "class" => "input" ],
                "label" => "Aantal personen"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
