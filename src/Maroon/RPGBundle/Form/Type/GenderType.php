<?php

namespace Maroon\RPGBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GenderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', 'textarea', ['attr' => ['rows' => 3]])
            ->add('statsInit', new StatsType())
            ->add('statsBonus', new StatsType())
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Maroon\RPGBundle\Entity\Gender'
        ));
    }

    public function getName()
    {
        return 'maroon_rpgbundle_gendertype';
    }
}
