<?php

namespace App\Form;


use App\Entity\Abonnement;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AbonnementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('numero')
            ->add('email')
            ->add('type', ChoiceType::class,
                array(
                    'choices' => array(
                        'Annuel' => 'Annuel',
                        'Semestriel' => 'Semestriel',
                        'Mensuel' => 'Mensuel',
                    )
                ))

         
           
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Abonnement::class,
        ]);
    }
}
