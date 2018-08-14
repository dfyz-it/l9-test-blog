<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('title')
          ->add(
            'category',
            EntityType::class,
            [
              'placeholder' => 'Chose a Category',
              'class' => Category::class,
              'expanded' => false,
              'multiple' => true,
              'choice_label' => 'name',
              'query_builder' => function (CategoryRepository $repo) {
                  return $repo->createAlphabeticalQueryBuilder();
              },
            ]
          )
          ->add('body');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
          [
            'data_class' => 'AppBundle\Entity\Post',
          ]
        );
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_post_form';
    }
}
