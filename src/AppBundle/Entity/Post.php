<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 11/07/18
 * Time: 16:25
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity (repositoryClass="AppBundle\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post {

  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string")
   */
  private $title;

  /**
   * @ORM\Column(type="string")
   */
  private $body;

  /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   * @ORM\JoinColumn(nullable=false)
   */
  private $user;

  /**
   * Many Category have many Posts.
   * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category")
   * @ORM\JoinTable(name="posts_categories",
   *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="categories_id", referencedColumnName="id")}
   * )
   */
  private $category;

  public function __construct() {
    $this->category = new ArrayCollection();
  }

  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * @param mixed $title
   */
  public function setTitle($title) {
    $this->title = $title;
  }

  /**
   * @return mixed
   */
  public function getBody() {
    return $this->body;
  }

  /**
   * @param mixed $body
   */
  public function setBody($body) {
    $this->body = $body;
  }

  /**
   * @return mixed
   */
  public function getUser() {
    return $this->user;
  }

  /**
   * @param mixed $user
   */
  public function setUser(User $user) {
    $this->user = $user;
  }

  /**
   * @return mixed
   */
  public function getCategory() {
    return $this->category;
  }

  /**
   * @param \AppBundle\Entity\Category $category
   */
  public function setCategory(Category $category) {
    $this->category[] = $category;
  }


}