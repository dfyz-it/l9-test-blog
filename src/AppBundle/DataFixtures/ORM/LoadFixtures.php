<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Entity\User_address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

// TODO: it is better to use separate fixture loaders for each entity
class LoadFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        foreach ($this->category() as $key => $value) {
            $category = new Category();
            $categories[] = $category;
            $category->setName($value);
            $category->setCode($key);
            $manager->persist($category);
        }

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setName('user'.$i);
            $user->setDateOfBirth(new \DateTime('2011-01-01T15:03:01.012345Z'));
            $user->setEmail('user'.$i.'@gmail.com');
            $user->setPlainPassword('asdasdasd');
            $user->setConfirmed(true);
            switch ($i) {
                case 0:
                    $user->setRoles(['ROLE_ADMIN','ROLE_USER']);
                    break;
                case 1:
                    $user->setRoles(['ROLE_MANAGER','ROLE_USER']);
                    break;
                default:
                    $user->setRoles(['ROLE_USER']);
            }


            $user_address = new User_address();
            $user_address->setCity('city'.$i);
            $user_address->setCountry('country'.$i);
            $user_address->setHouse($i);
            $user_address->setStreet('street'.$i);
            $user_address->setUser($user);

            $manager->persist($user);
            $manager->persist($user_address);

            for ($f = 0; $f < 4; $f++) {
                $post = new Post();
                $post->setTitle('title '.rand(0, 50));
                $post->setBody('body '.rand(0, 50));
                $post->setUser($user);
                $post->setCategory([$categories[rand(0, 13)]]);
                $post->setChecked(true);
                $manager->persist($post);
            }
        }
        $manager->flush();
    }

    public function category()
    {
        $categorys = [
          0 => 'Finance',
          1 => 'Exotic option',
          2 => 'Options broker',
          3 => 'Protective put',
          4 => 'Ratio spread',
          5 => 'Intermarket Spread',
          6 => 'Black model',
          7 => 'Jump diffusion',
          8 => 'Lookback option',
          9 => 'Volatility arbitrage',
          10 => 'Option style',
          11 => 'Covered warrant',
          12 => 'Straddle',
          13 => 'Commodore option',
        ];

        return $categorys;
    }

}