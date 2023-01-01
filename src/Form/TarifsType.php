<?php

namespace App\Form;

use App\Entity\Tarifs;
use App\Entity\Prestation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TarifsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('tarif')
            ->add('prestation', EntityType::class, [
                'class' => Prestation::class,
                'choice_label' => 'name',
                'label' => 'Prestation',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tarifs::class,
        ]);
    }
}
