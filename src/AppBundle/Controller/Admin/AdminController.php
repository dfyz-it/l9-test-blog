<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 20/07/18
 * Time: 16:26
 */

namespace AppBundle\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 *
 * @Security("is_granted('ROLE_MANAGER')")
 * @Route("/admin")
 */
class AdminController extends Controller
{

    /**
     * @Route("/", name="admin_button")
     */
    public function indexAction()
    {

        $btn = 'assd';

        return $this->render(
          'admin/select.html.twig',
          array(
            'btn' => $btn,
          )
        );
    }

}