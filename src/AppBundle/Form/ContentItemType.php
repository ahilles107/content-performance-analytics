<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url')
            ->add('title')
            ->add('publishedDate', 'Symfony\Component\Form\Extension\Core\Type\DateTimeType', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd H:mm:s',
            ))
            ->add('author')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ContentItem',
            'csrf_protection'   => false,
        ));
    }
}
