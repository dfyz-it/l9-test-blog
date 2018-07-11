<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 11/07/18
 * Time: 16:25
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_address")
 */
class User_address {

  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string")
   */
  private $city;

  /**
   * @ORM\Column(type="string")
   */
  private $country;

  /**
   * @ORM\Column(type="string")
   */
  private $street;

  /**
   * @ORM\Column(type="string")
   */
  private $house;

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
  public function getCity() {
    return $this->city;
  }

  /**
   * @param mixed $city
   */
  public function setCity($city) {
    $this->city = $city;
  }

  /**
   * @return mixed
   */
  public function getCountry() {
    return $this->country;
  }

  /**
   * @param mixed $country
   */
  public function setCountry($country) {
    $this->country = $country;
  }

  /**
   * @return mixed
   */
  public function getStreet() {
    return $this->street;
  }

  /**
   * @param mixed $street
   */
  public function setStreet($street) {
    $this->street = $street;
  }

  /**
   * @return mixed
   */
  public function getHouse() {
    return $this->house;
  }

  /**
   * @param mixed $house
   */
  public function setHouse($house) {
    $this->house = $house;
  }


}