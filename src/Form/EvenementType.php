<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre de l\'événement',
                'attr'  => ['class' => 'form-control', 'placeholder' => 'Ex: Randonnée des falaises d\'Étretat'],
                'constraints' => [new NotBlank()],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr'  => ['class' => 'form-control', 'rows' => 5,
                            'placeholder' => 'Décrivez l\'événement, le programme, ce qu\'il faut prévoir...'],
                'constraints' => [new NotBlank()],
            ])
            ->add('dateDebut', DateTimeType::class, [
                'label'  => 'Date et heure de début',
                'widget' => 'single_text',
                'attr'   => ['class' => 'form-control'],
                'constraints' => [new NotBlank()],
            ])
            ->add('dateFin', DateTimeType::class, [
                'label'    => 'Date et heure de fin',
                'widget'   => 'single_text',
                'required' => false,
                'attr'     => ['class' => 'form-control'],
            ])
            ->add('adresse', TextType::class, [
                'label'    => 'Lieu / Adresse',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Ex: Étretat, Seine-Maritime'],
            ])
            ->add('placesMax', IntegerType::class, [
                'label'    => 'Nombre de places maximum',
                'required' => false,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Laisser vide si illimité'],
            ])
            ->add('estGratuit', CheckboxType::class, [
                'label'    => 'Événement gratuit',
                'required' => false,
                'attr'     => ['class' => 'form-check-input'],
            ])
            ->add('prix', NumberType::class, [
                'label'    => 'Prix (€)',
                'required' => false,
                'scale'    => 2,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Laisser vide si gratuit'],
            ])
            ->add('latitude', NumberType::class, [
                'label'    => 'Latitude',
                'required' => false,
                'scale'    => 6,
                'attr'     => ['class' => 'form-control', 'placeholder' => '49.7070', 'step' => '0.000001'],
            ])
            ->add('longitude', NumberType::class, [
                'label'    => 'Longitude',
                'required' => false,
                'scale'    => 6,
                'attr'     => ['class' => 'form-control', 'placeholder' => '0.2049', 'step' => '0.000001'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}