<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Band;
use App\Entity\Concert;
use App\Entity\ConcertHall;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConcertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('concertName', TextType::class, [
                'label' => 'Concert Name'
            ])
            ->add('concertDate', DateType::class, [
                'widget' => 'choice',
                'format' => 'dd / MM / yyyy'
            ])
            ->add('bands', EntityType::class, [
                'class' => Band::class,
                'label' => 'Crews',
                'choice_label' => 'bandName',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('artists', EntityType::class, [
                'class' => Artist::class,
                'label' => 'Dancers',
                'choice_label' => 'artistName',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('concertHall', EntityType::class, [
                'class' => ConcertHall::class,
                'label' => 'Location',
                'choice_label' => 'concertHallName'
            ])
            ->add('save', SubmitType::class, [
               'label' => 'Save'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Concert::class,
        ]);
    }
}
