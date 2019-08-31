<?php

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant')
            ->add('nomEnvoyeur')
            ->add('prenomEnvoyeur')
            ->add('telEnvoyeur')
            ->add('nomBene')
            ->add('prenomBene')
            ->add('numBene')
            ->add('numCniBene')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
            'csrf_protection'=>false
        ]);
    }
}
