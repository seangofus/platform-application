<?php

namespace Jov\Bundle\CategoryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            'text',
            array(
                'label'    => 'jov.category.name.label',
                'required' => true
            )
        )
        ->add(
            'slug',
            'text',
            array(
                'label'    => 'jov.category.slug.label',
                'required' => true
            )
        )
        ->add(
            'description',
            'textarea',
            array(
                'label'    => 'jov.category.description.label',
                'required' => false
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Jov\Bundle\CategoryBundle\Entity\Category',
                'intention'  => 'tag',
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jov_category_category';
    }
}
