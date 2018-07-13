<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Entity\User_address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;


class LoadFixtures extends Fixture {

  public function load(ObjectManager $manager) {
    //    $loader = new NativeLoader();
    //    $objectSet = $loader->loadFile(__DIR__.'/fixtures.yml')->getObjects();
    //    foreach($objectSet as $object) {
    //      $manager->persist($object);
    //    }
    //    $manager->flush();

    for ($i = 0; $i < 20; $i++) {
      $user = new User();
      $user->setName('user' .$i);
      $user->setDateOfBirth(new \DateTime('2011-01-01T15:03:01.012345Z'));
      $user->setEmail('user' . $i . '@gmail.com');
      $manager->persist($user);
//
      $user_address = new User_address();
      $user_address->setCity('city'.$i);
      $user_address->setCountry('country'.$i);
      $user_address->setHouse($i);
      $user_address->setStreet('street'.$i);
      $user_address->setUser($user);
      $manager->persist($user_address);

      $post = new Post();
      $post->setTitle('title'.$i);
      $post->setBody('body'.$i);
      $post->setUser($user);
      $manager->persist($post);

      $category = new Category();
      $category->setName('name'.$i);
      $category->setCode('code'.$i);
      $category->setPost($post);
      $manager->persist($category);

    }

    $manager->flush();
  }

}