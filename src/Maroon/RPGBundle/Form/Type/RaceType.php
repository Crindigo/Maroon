<?php

namespace Maroon\RPGBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RaceType extends AbstractType
{
    private $statKeys = array();

    public function __construct(array $statKeys)
    {
        $this->statKeys = $statKeys;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name')
            ->add('description', 'textarea', ['attr' => ['rows' => 3]])
            ->add('selectableGenders', 'entity', array(
                'label' => 'Selectable Genders',
                'class' => 'MaroonRPGBundle:Gender',
                'property' => 'name',
                //'expanded' => true,
                'multiple' => true,
            ))
            ->add('selectableJobs', 'entity', array(
                'label' => 'Selectable Jobs',
                'class' => 'MaroonRPGBundle:Job',
                'property' => 'name',
                'expanded' => true,
                'multiple' => true,
            ))
        ;

        $first = true;
        foreach ( $this->statKeys as $stat ) {
            $builder->add("statsInit:$stat", 'integer', [
                'label_render' => $first,
                'label' => 'Initial Stats',
                'widget_controls_attr' => ['class' => 'stats-add-on'],
                'widget_addon' => [
                    'type' => 'prepend',
                    'text' => strtoupper($stat) . ':',
                ],
                'attr' => ['class' => 'input-mini'],
            ]);
            $first = false;
        }

        $first = true;
        foreach ( $this->statKeys as $stat ) {
            $builder->add("statsBonus:$stat", 'integer', [
                'label_render' => $first,
                'label' => 'Bonus per Level',
                'widget_controls_attr' => ['class' => 'stats-add-on'],
                'widget_addon' => [
                    'type' => 'prepend',
                    'text' => strtoupper($stat) . ':',
                ],
                'attr' => ['class' => 'input-mini'],
            ]);
            $first = false;
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //$resolver->setDefaults(array(
        //    'data_class' => 'Maroon\RPGBundle\Entity\Race'
        //));
    }

    public function getName()
    {
        return 'maroon_rpgbundle_racetype';
    }
}
