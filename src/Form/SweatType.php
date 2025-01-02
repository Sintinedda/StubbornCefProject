<?php

namespace App\Form;

use App\Entity\SweatShirt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SweatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('img', FileType::class, array(
                'label' => false,
                'mapped' =>false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => 'image/jpeg',
                        'mimeTypesMessage' => 'Veuillez insérez une image valide'
                    ])
                ]
            ))
            ->add('name', TextType::class)
            ->add('price', NumberType::class)
            ->add('stock_xs', NumberType::class)
            ->add('stock_s', NumberType::class)
            ->add('stock_m', NumberType::class)
            ->add('stock_l', NumberType::class)
            ->add('stock_xl', NumberType::class)
            ->add('isTop', CheckboxType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SweatShirt::class,
        ]);
    }
}
?>