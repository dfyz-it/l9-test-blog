<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 24/07/18
 * Time: 11:14
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="confirm_register_code")
 */
class ConfirmRegisterCode
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     */
    private $confirm_code;

    /**
     * @ORM\Column(type="date")
     */
    private $expiration_date;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getConfirmCode()
    {
        return $this->confirm_code;
    }

    /**
     * @param mixed $confirm_code
     */
    public function setConfirmCode($confirm_code)
    {
        $this->confirm_code = $confirm_code;
    }

    /**
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expiration_date;
    }

    /**
     * @param mixed $expiration_date
     */
    public function setExpirationDate(\DateTime $expiration_date)
    {
        $this->expiration_date = $expiration_date;
    }

}