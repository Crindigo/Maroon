<?php

namespace Maroon\RPGBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class NewCharFormType extends AbstractType
{
    private $params = array();

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Character Name'))
            ->add('race', 'choice', array(
                'label' => 'Race',
                'choices' => $this->params['races'],
                'empty_value' => 'Select a race',
                'help_block' => 'Select a race to view additional details.',
            ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'maroon_rpg_new_character';
    }
}
