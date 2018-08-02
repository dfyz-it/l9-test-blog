<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('name')
          ->add('email')
          ->add(
            'dateOfBirth',
            DateType::class,
            [
              'widget' => 'single_text',
              'attr' => [
                'class' => 'js-datepicker',
              ],
              'html5' => true,
            ]
          )
          ->add('street')
          ->add('house')
          ->add(
            'confirmed',
            ChoiceType::class,
            [
              'choices' => [
                'Yes' => true,
                'No' => false,
              ],
            ]
          )
          ->add(
            'blocked',
            ChoiceType::class,
            [
              'choices' => [
                'Yes' => true,
                'No' => false,
              ],
            ]
          );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
          [
            'data_class' => 'AppBundle\Entity\User',
          ]
        );
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_user_form_type';
    }
}
