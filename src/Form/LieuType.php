<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Lieu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre du lieu',
                'constraints' => [
                    new NotBlank(message: 'Le titre est obligatoire'),
                    new Length(min: 5, max: 255),
                ],
                'attr' => [
                    'placeholder' => 'Ex: Falaises d\'Étretat',
                    'class' => 'form-control',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'constraints' => [
                    new NotBlank(message: 'La description est obligatoire'),
                    new Length(min: 20),
                ],
                'attr' => [
                    'placeholder' => 'Décrivez ce lieu, ce qu\'on peut y faire, comment y accéder...',
                    'class' => 'form-control',
                    'rows' => 6,
                ],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse / Localité',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: Étretat, Seine-Maritime',
                    'class' => 'form-control',
                ],
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'Latitude',
                'required' => false,
                'scale' => 6,
                'attr' => [
                    'placeholder' => 'Ex: 49.7070',
                    'class' => 'form-control',
                    'step' => '0.000001',
                ],
                'help' => 'Cliquez sur la carte pour remplir automatiquement',
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'Longitude',
                'required' => false,
                'scale' => 6,
                'attr' => [
                    'placeholder' => 'Ex: 0.2049',
                    'class' => 'form-control',
                    'step' => '0.000001',
                ],
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'placeholder' => '-- Choisir une catégorie --',
                'constraints' => [
                    new NotBlank(message: 'Veuillez choisir une catégorie'),
                ],
                'attr' => ['class' => 'form-select'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}