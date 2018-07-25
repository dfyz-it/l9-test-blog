<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 24/07/18
 * Time: 16:03
 */

namespace AppBundle\Service;


use AppBundle\Entity\ConfirmRegisterCode;
use AppBundle\Entity\User;

class ConfirmRegisterCodeService
{

    public function isRegisterCodeValid(
      ConfirmRegisterCode $user,
      $registercode
    ) {

        if ($user->getExpirationDate()->format('Y-m-d') >= date('Y-m-d')) {

            if ($user->getConfirmCode() == $registercode['_code']) {
                return true;
            }
        }

        return false;
    }

    public function ChangeConfirmStatus(User $user, $status)
    {
        $user->setConfirmed($status);

        return $user;
    }

    public function createConfirmCode(User $user)
    {
        $user_code = new ConfirmRegisterCode();
        $user_code->setConfirmCode(rand(100, 999));
        $user_code->setUser($user);
        $user_code->setExpirationDate(new \DateTime('+1 day'));

        return $user_code;
    }
}