<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 13/07/18
 * Time: 16:15
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostController extends Controller {

  /**
   * @Route("/{category_code}/posts", name="category_show_posts")
   * @Method("GET")
   */
  public function getPostAction($category_code, Request $request) {

    $em = $this->getDoctrine()->getManager();

    $posts = $em->getRepository('AppBundle:Post')
      ->findAllPostByCategory($category_code);

    $posts = $this->get('knp_paginator')
      ->paginate($posts, $request->query->get('page', 1), 2);

    dump($posts);

    return $this->render('blog/posts.html.twig', [
      'posts' => $posts,
    ]);
  }
}