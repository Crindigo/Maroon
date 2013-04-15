<?php

namespace Maroon\RPGBundle\Form\Type;

use Maroon\RPGBundle\Entity\CharStats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', 'textarea', ['attr' => ['rows' => 3]])
            ->add('selectableGenders', 'entity', array(
                'label' => 'Selectable Genders',
                'class' => 'MaroonRPGBundle:Gender',
                'property' => 'name',
                'expanded' => true,
                'multiple' => true,
            ))
            ->add('selectableJobs', 'entity', array(
                'label' => 'Selectable Jobs',
                'class' => 'MaroonRPGBundle:Job',
                'property' => 'name',
                'expanded' => true,
                'multiple' => true,
            ))
            ->add('statsInit', new StatsType())
            ->add('statsBonus', new StatsType())
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Maroon\RPGBundle\Entity\Race'
        ));
    }

    public function getName()
    {
        return 'maroon_rpgbundle_racetype';
    }
}
