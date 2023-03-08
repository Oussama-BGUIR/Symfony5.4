<?php

namespace App\Form;

use App\Entity\Offre;
use App\Entity\Abonnement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;


class OffreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('points') 
            ->add('prix')
            ->add('pourcentage')
            ->add('dateDebut', DateTimeType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Date début non valide'
                    ]),
                    new GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'La date debut doit être dans le futur'
                    ])
                    ],
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])
            
            ->add('dateFin', DateTimeType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Date fin non valide'
                    ]),
                    new GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'La date fin doit être dans le futur'
                    ])
                    ],
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])
            ->add('abonnement_nom',EntityType::class,
                ['class' => Abonnement::class,
                'choice_label' => 'nom',
                'multiple' => false])

           
            
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Offre::class,
        ]);
    }
}
