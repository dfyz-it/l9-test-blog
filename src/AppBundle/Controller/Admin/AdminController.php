<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 20/07/18
 * Time: 16:26
 */

namespace AppBundle\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     * @Route("/{filter}", name="admin_main_page")
     * @Method("GET")
     */
    public function indexAction($filter = NULL)
    {


        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:Post')
          ->createQueryAdminFilter($filter);

        return $this->render(
          'admin/AdminMainPage.html.twig',
          array(
            'posts' => $posts,
          )
        );
    }



}