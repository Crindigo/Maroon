<?php

namespace Maroon\RPGBundle\Form\Type;

use Maroon\RPGBundle\Entity\CharStats;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class StatType extends AbstractType
{
    public function __construct()
    {
        $stats = CharStats::$statAliases;
        unset($stats['maxhp'], $stats['maxsp']);
        $this->statKeys = array_keys($stats);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ( $this->statKeys as $stat ) {
            $builder->add($stat, 'integer', [
                'label_render' => false,
                'widget_controls_attr' => ['class' => 'stats-add-on'],
                'widget_addon' => [
                    'type' => 'prepend',
                    'text' => strtoupper($stat) . ':',
                ],
                'attr' => ['class' => 'input-mini'],
            ]);
        }
    }

    public function getName()
    {
        return 'maroon_rpg_stat';
    }
}
