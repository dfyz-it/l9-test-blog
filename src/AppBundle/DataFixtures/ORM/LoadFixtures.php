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
    $categorys = [
      'Finance',
      'Exotic option',
      'Options broker',
      'Protective put',
      'Ratio spread',
      'Intermarket Spread',
      'Black model',
      'Jump diffusion',
      'Lookback option',
      'Volatility arbitrage',
      'Option style',
      'Covered warrant',
      'Straddle',
      'Commodore option',
    ];


    foreach ($categorys as $key => $value) {
      $category = new Category();
      $category->setName($value);
      $category->setCode($key);
      $manager->persist($category);
    }

    for ($i = 0; $i < 5; $i++) {
      $user = new User();
      $user->setName('user' . $i);
      $user->setDateOfBirth(new \DateTime('2011-01-01T15:03:01.012345Z'));
      $user->setEmail('user' . $i . '@gmail.com');
      $manager->persist($user);

      $user_address = new User_address();
      $user_address->setCity('city' . $i);
      $user_address->setCountry('country' . $i);
      $user_address->setHouse($i);
      $user_address->setStreet('street' . $i);
      $user_address->setUser($user);
      $manager->persist($user_address);

      for ($f = 0; $f < 4; $f++) {



        $post = new Post();
        $post->setTitle('title' . $i);
        $post->setBody('body' . $i);
        $post->setUser($user);
//        $post->setCategory($category);
        $manager->persist($post);
      }
    }

      $manager->flush();

  }



  //
  //  public function category() {
  //    $categorys = [
  //      'Finance',
  //      'Exotic option',
  //      'Options broker',
  //      'Protective put',
  //      'Ratio spread',
  //      'Intermarket Spread',
  //      'Black model',
  //      'Jump diffusion',
  //      'Lookback option',
  //      'Volatility arbitrage',
  //      'Option style',
  //      'Covered warrant',
  //      'Straddle',
  //      'Commodore option',
  //    ];
  //
  //    $key = array_rand($genera);
  //
  //    return $genera[$key];
  //  }

}