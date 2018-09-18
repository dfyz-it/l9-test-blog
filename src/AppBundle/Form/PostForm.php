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
              'expanded' => true,
              'multiple' => true,
              'choice_label' => 'name',
              'query_builder' => function (CategoryRepository $repo) {
                  return $repo->createAlphabeticalQueryBuilder();
              },
            ]
          )
            // TODO User should not be able to check/un-check his own posts, only admin and moderator are able to do it
            // TODO it is not enough to hide field in template since user could send data via Postman, so access should be checked in the form itself
          ->add('checked')
          ->add('body');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
          [
              //TODO: use Post::class constant instead of class name string
            'data_class' => 'AppBundle\Entity\Post',
          ]
        );
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_post_form';
    }
}
