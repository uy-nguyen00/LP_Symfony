<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Band;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bandName')
            ->add('pictureFile', FileType::class, [
                'mapped' => false,
                'required' => false
            ])
            ->add('artistMembers', EntityType::class, [
                'class' => Artist::class,
                'label' => 'Dancers',
                'choice_label' => 'artistName',
                'multiple' => true,
                'expanded' => true
            ])
//            ->add('concerts')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
