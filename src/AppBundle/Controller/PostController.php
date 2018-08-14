<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 13/07/18
 * Time: 16:15
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostForm;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostController extends Controller
{


    /**
     * @Route("/{category_code}/posts", name="category_show_posts")
     * @Method("GET")
     */
    public function getPostbyCategoryCodeAction(
      $category_code,
      Request $request
    ) {

        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')
          ->findAllPostByCategory($category_code);

        $posts = $this->get('knp_paginator')
          ->paginate($posts, $request->query->get('page', 1), 2);

        return $this->render(
          'blog/posts.html.twig',
          [
            'posts' => $posts,
          ]
        );
    }

    /**
     * @Route("/{user_id}/myposts", name="user_show_posts")
     * @Method("GET")
     */
    public function getPostbyUserAction($user_id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')
          ->findBy(
            ['user' => $user_id]
          );

        $posts = $this->get('knp_paginator')
          ->paginate($posts, $request->query->get('page', 1), 7);

        return $this->render(
          'blog/posts.html.twig',
          [
            'posts' => $posts,
          ]
        );
    }

    /**
     * @Route("/{user_id}/myposts/add", name="user_add_post")
     */
    public function addUserPostAction($user_id, Request $request)
    {

        $form = $this->createForm(PostForm::class);
        $form->handleRequest($request);


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')
          ->findOneBy(
            ['id' => $user_id]
          );


        if ($form->isValid()) {

            /** @var \AppBundle\Entity\Post $post */
            $post = $form->getData();
            //            $post->setCategory(1);


            $post->setUser($user);

            //            $user->setRoles(['ROLE_USER']);
            //            $user->setConfirmed(false);


            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash(
              'success',
              ''
            );

            return $this->redirectToRoute('homepage');

        }

        return $this->render(
          'blog/form/FormPost.html.twig',
          [
            'form' => $form->createView(),
          ]
        );
    }

    /**
     * @Route("/post/{id}/edit", name="post_edit")
     */
    public function editAction(Request $request, Post $post) {
        $form = $this->createForm(PostForm::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('success', 'Post updated!');
            return $this->redirectToRoute( 'homepage');
        }
        return $this->render('blog/form/FormPost.html.twig', [
          'form' => $form->createView(),
        ]);
    }
}