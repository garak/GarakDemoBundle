<?php

namespace Garak\DemoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\MinLength;

class FilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $category = empty($options['data']['category']) ? null : $options['data']['category'];
        $price = empty($options['data']['price']) ? null : $options['data']['price'];
        $name = empty($options['data']['name']) ? null : $options['data']['name'];

        $builder
            ->add('category', 'entity', array('required' => false, 'class' => 'GarakDemoBundle:Category', 'empty_value' => '', 'data' => $category))
            ->add('price', 'text', array('required' => false, 'data' => $price))
            ->add('name', 'text', array('required' => false, 'data' => $name))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filter';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)
    {
        return array('csrf_protection' => false);
    }
}