<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 11/07/18
 * Time: 12:29
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{

    public function homepageAction()
    {

        $em = $this->getDoctrine()->getManager();

        $categorys = $em->getRepository('AppBundle:Category')
          ->findAll();

        return $this->render(
          'main/homepage.html.twig',
          [
            'categorys' => $categorys,
          ]
        );

    }

}


