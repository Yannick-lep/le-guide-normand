<?php

namespace App\Form;

use App\Entity\Avis;
use Override;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class AvisType extends AbstractType
{
    #[Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', ChoiceType::class, [
                'label'   => 'Note',
                'choices' => [
                   '⭐ 1 - Décevant'   =>1,
                    '⭐⭐ 2 — Moyen'      => 2,
                    '⭐⭐⭐ 3 — Bien'      => 3,
                    '⭐⭐⭐⭐ 4 — Très bien' => 4,
                    '⭐⭐⭐⭐⭐ 5 — Excellent' => 5,
                ],
                'expanded' => false,
                'attr'     => ['class' => 'form-select'],
                'constraints' => [
                    new NotBlank(message: 'Veuillez choisir une note'),
                    new range(min: 1, max: 5),
                ],
            ])
            ->add('commentaire', TextareaType::class, [
                'label' => 'Votre commentaie',
                'attr'  => [
                    'class'       => 'form-control',
                    'rows'        => 4,
                    'placeholder' => 'Partagez votre expérience...',
                ],
                'constraints' => [
                    new NotBlank(message: 'Le commentaire est obligatoire'),
                ],
            ])
        ;
    }

    #[Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}