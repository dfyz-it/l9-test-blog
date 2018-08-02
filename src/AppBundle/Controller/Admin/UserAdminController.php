<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 01/08/18
 * Time: 11:37
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\User;
use AppBundle\Form\UserFormType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/admin")
 */
class UserAdminController extends Controller
{

    /**
     * @Route("/users", name="admin_users_list")
     */
    public function indexAction()
    {

        $users = $this->getDoctrine()
          ->getRepository('AppBundle:User')
          ->findAll();

        return $this->render(
          'admin/users/list.html.twig',
          array(
            'users' => $users,
          )
        );
    }


    /**
     * @Route("/users/{id}/edit", name="admin_users_edit")
     */
    public function editAction(Request $request, User $user)
    {
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $genus = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($genus);
            $em->flush();
            $this->addFlash('success', 'User updated!');

            return $this->redirectToRoute('admin_users_list');
        }

        return $this->render(
          'admin/users/edit.html.twig',
          [
            'userForm' => $form->createView(),
          ]
        );
    }

}