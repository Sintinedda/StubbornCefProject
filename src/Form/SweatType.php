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

class SweatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('price', NumberType::class)
            ->add('isTop', CheckboxType::class, [
                'required' => false
            ])
            ->add('img', FileType::class, array('data_class' => null))
            ->add('stock_xs', NumberType::class)
            ->add('stock_s', NumberType::class)
            ->add('stock_m', NumberType::class)
            ->add('stock_l', NumberType::class)
            ->add('stock_xl', NumberType::class)
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