<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 13/07/18
 * Time: 16:15
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Form\PostForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
          ->findAllPostByCategoryChecked($category_code);

        // TODO paginator should work with query builder, but not with array of posts, this wont work when there would be a lot of posts in db
        $posts = $this->get('knp_paginator')
          ->paginate($posts, $request->query->get('page', 1), 2);

        return $this->render(
          'blog/CategoryPosts.html.twig',
          [
            'posts' => $posts,
          ]
        );
    }

    /**
     * TODO: {user_id} parameter is not required here as user could be gotten from security context
     * @Route("/{user_id}/myposts", name="user_show_posts")
     * @Method("GET")
     */
    public function getPostbyUserAction(Request $request, $user_id)
    {

        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')
          ->findBy(
            ['user' => $user_id]
          );

        $posts = $this->get('knp_paginator')
          ->paginate($posts, $request->query->get('page', 1), 7);

        return $this->render(
          'blog/CategoryPosts.html.twig',
          [
            'posts' => $posts,
            'user_id' => $this->getUser()->getId(),
          ]
        );
    }

    /**
     * TODO: need to add "Create post" link in some template
     * @Route("/{user}/myposts/add", name="user_add_post")
     */
    public function addUserPostAction(Request $request, User $user)
    {
        $form = $this->createForm(PostForm::class);
        $form->handleRequest($request);

        // TODO: it is better to check $form->isSubmitted() as well
        if ($form->isValid()) {

            /** @var \AppBundle\Entity\Post $post */
            $post = $form->getData();
            $post->setUser($user);
            $post->setChecked(false);

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
    public function editAction(Request $request, Post $post)
    {
        if ($this->getUser()->getId() == $post->getUser()->getId()
          || $this->get('security.authorization_checker')->isGranted(
            'ROLE_MANAGER'
          )) {
            $form = $this->createForm(PostForm::class, $post);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $post = $form->getData();
                if (!$this->get('security.authorization_checker')->isGranted(
                  'ROLE_MANAGER'
                )) {
                    $post->setChecked(false);
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($post);
                $em->flush();
                $this->addFlash('success', 'Post updated!');

                return $this->redirectToRoute(
                  'post_edit',
                  [
                    'id' => $post->getId(),
                  ]
                );
            }

            return $this->render(
              'blog/form/FormPost.html.twig',
              [
                'form' => $form->createView(),
              ]
            );

        } else {
            throw $this->createAccessDeniedException('wrong user');
        }
    }

    /**
     * TODO: better to move this action to different controller from Admin namespace
     * @Route("/admin/masscheck", name="mass_check_action")
     * @Security("is_granted('ROLE_ADMIN')")
     * @Method("POST")
     *
     */
    public function massCheckAction(Request $request)
    {
        $id_list = explode(",", $request->get('id'));

        foreach ($id_list as $post_id) {
            $em = $this->getDoctrine()->getManager();

            $post = $em->getRepository('AppBundle:Post')
                // TODO this is mass action, so all posts should be selected with one request
              ->findOneBy(['id' => $post_id]);

            $post->setChecked(true);
            $em->persist($post);
            $em->flush();
        }

        $this->addFlash('success', 'Post updated!');

        return $this->render('admin/AdminMainPage.html.twig');
    }
}