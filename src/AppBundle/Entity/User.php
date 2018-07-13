<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 11/07/18
 * Time: 15:29
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User {

  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string")
   */
  private $name;

  /**
   * @ORM\Column(type="string", unique=true)
   */
  private $email;

  /**
   * @ORM\Column(type="date")
   */
  private $date_of_birth;


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
  public function getName() {
    return $this->name;
  }

  /**
   * @param mixed $name
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * @return mixed
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * @param mixed $email
   */
  public function setEmail($email) {
    $this->email = $email;
  }

  /**
   * @return mixed
   */
  public function getDateOfBirth() {
    return $this->date_of_birth;
  }

  /**
   * @param mixed $date_of_birth
   */
  public function setDateOfBirth(\DateTime $date_of_birth = NULL) {
    $this->date_of_birth = $date_of_birth;
  }


}