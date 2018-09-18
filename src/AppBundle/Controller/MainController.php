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

        $categories = $em->getRepository('AppBundle:Category')
        ->findAllCategoryswithPosts();

        return $this->render(
          'main/homepage.html.twig',
          [
            'categorys' => $categories,
            // TODO: posts count should be computed using repository method
            'recentPostsCount' => 1,
          ]
        );
    }
}


