<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 01/08/18
 * Time: 16:01
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{

    /**
     * @return \AppBundle\Entity\Category[]
     */
    public function findAllCategoryswithPosts()
    {
        return $this->createQueryBuilder('category')
          ->leftJoin('category.posts', 'cp')


          ->getQuery()
          ->execute();
    }
}

