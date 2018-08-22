<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 03/07/18
 * Time: 16:25
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{

    /**
     * @return \AppBundle\Entity\Post[]
     */
    public function findAllPostByCategoryChecked($category_code)
    {

        return $this->createQueryBuilder('post')
          ->leftJoin('post.user', 'u')
          ->addSelect('u')
          ->join('post.category', 'c')
          ->where('c.code = :id')
          ->setParameter('id', $category_code)
          ->andWhere('post.checked = :checked')
          ->setParameter('checked', true)
          ->orderBy('post.id', 'DESC')
          ->getQuery()
          ->execute();
    }

    /**
     * @return \AppBundle\Entity\Post[]
     */
    public function findAllPostByUser($category_code)
    {

        return $this->createQueryBuilder('post')
          ->leftJoin('post.user', 'u')
          ->addSelect('u')
          ->join('post.category', 'c')
          ->where('c.code = :id')
          ->setParameter('id', $category_code)
          ->orderBy('post.id', 'DESC')
          ->getQuery()
          ->execute();
    }

    public function createQueryAdminFilter($filter = null)
    {

        if (is_null($filter)) {
            return $this->createQueryBuilder('post')
              ->orderBy('post.id', 'DESC')
              ->getQuery()
              ->execute();
        }

        return $this->createQueryBuilder('post')
          ->where('post.checked = :checked')
          ->setParameter('checked', $filter)
          ->orderBy('post.id', 'DESC')
          ->getQuery()
          ->execute();
    }
}