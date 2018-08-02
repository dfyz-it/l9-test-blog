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
    public function findAllPostByCategory($category_code)
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




}