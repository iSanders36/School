<?php

use App\Entity\Receipt;

class ReceiptType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('payed')
            ->add('reservation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Receipt::class,
        ]);
    }
}
