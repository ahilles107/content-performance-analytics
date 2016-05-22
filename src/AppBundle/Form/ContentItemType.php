<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ContentItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gaPath', null, [
                'constraints' => [
                    new NotBlank(),
                ]
           ])
            ->add('publicUrl', null, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('title', null, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('publishedDate', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd H:mm:s',
                'constraints' => [
                    new NotBlank(),
                    new DateTime()
                ]
            ])
            ->add('author', null, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
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
