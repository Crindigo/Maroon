<?php
/**
 * Created by IntelliJ IDEA.
 * User: steven
 * Date: 4/17/13
 * Time: 11:24 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Maroon\RPGBundle\Form\Type;


use Maroon\RPGBundle\Form\ModifierListener;
use Maroon\RPGBundle\Form\ModifierTransformer;
use Maroon\RPGBundle\Validator\Constraints\Modifier;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ModifierType extends AbstractType
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ModifierTransformer($this->container);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $url = $this->container->get('router')->generate('admin_modifier_ref', [], UrlGeneratorInterface::ABSOLUTE_PATH);

        $resolver->setDefaults(array(
            'attr' => array(
                'class' => 'span6',
                'rows' => 10,
            ),
            'required' => false,
//            'constraints' => new Modifier(),
            'label' => 'Modifiers',
            'help_block' => '<a class="btn btn-small" style="margin-top: 4px;" href="' . $url . '" target="_blank"><i class="icon-book"></i> Modifier Reference</a>',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'modifier';
    }

    public function getParent()
    {
        return 'textarea';
    }
}