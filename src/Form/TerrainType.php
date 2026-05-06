<?php

namespace App\Form;

use App\Entity\Terrain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class TerrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre du terrain',
                'attr'  => ['class' => 'form-control', 'placeholder' => 'Ex: Grand jardin en bord de rivière'],
                'constraints' => [new NotBlank()],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr'  => ['class' => 'form-control', 'rows' => 5,
                            'placeholder' => 'Décrivez votre terrain, l\'environnement, les accès...'],
                'constraints' => [new NotBlank()],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse / Localité',
                'attr'  => ['class' => 'form-control', 'placeholder' => 'Ex: Lyons-la-Forêt, Eure'],
                'constraints' => [new NotBlank()],
            ])
            ->add('latitude', NumberType::class, [
                'label'    => 'Latitude',
                'required' => false,
                'scale'    => 6,
                'attr'     => ['class' => 'form-control', 'placeholder' => '49.4003', 'step' => '0.000001'],
                'help'     => 'Cliquez sur la carte pour remplir automatiquement',
            ])
            ->add('longitude', NumberType::class, [
                'label'    => 'Longitude',
                'required' => false,
                'scale'    => 6,
                'attr'     => ['class' => 'form-control', 'placeholder' => '1.4772', 'step' => '0.000001'],
            ])
            ->add('capacitePersonnes', IntegerType::class, [
                'label' => 'Capacité (personnes)',
                'attr'  => ['class' => 'form-control', 'min' => 1, 'max' => 50],
                'constraints' => [new NotBlank(), new Positive()],
            ])
            ->add('prixNuit', NumberType::class, [
                'label'    => 'Prix par nuit (€)',
                'required' => false,
                'scale'    => 2,
                'attr'     => ['class' => 'form-control', 'placeholder' => 'Laisser vide si gratuit'],
                'help'     => 'Laisser vide si vous proposez l\'accès gratuitement',
            ])
            ->add('aDouche', CheckboxType::class, [
                'label'    => 'Douche disponible',
                'required' => false,
                'attr'     => ['class' => 'form-check-input'],
            ])
            ->add('aElectricite', CheckboxType::class, [
                'label'    => 'Électricité disponible',
                'required' => false,
                'attr'     => ['class' => 'form-check-input'],
            ])
            ->add('aToilettes', CheckboxType::class, [
                'label'    => 'Toilettes disponibles',
                'required' => false,
                'attr'     => ['class' => 'form-check-input'],
            ])
            ->add('aWifi', CheckboxType::class, [
                'label'    => 'Wifi disponible',
                'required' => false,
                'attr'     => ['class' => 'form-check-input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Terrain::class,
        ]);
    }
}
