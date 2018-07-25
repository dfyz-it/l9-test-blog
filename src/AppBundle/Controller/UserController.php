<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 19/07/18
 * Time: 11:27
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\EmailConfirm;
use AppBundle\Form\UserRegistrationForm;
use AppBundle\Service\ConfirmRegisterCodeService;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(UserRegistrationForm::class);
        $form->handleRequest($request);
        if ($form->isValid()) {

            /** @var \AppBundle\Entity\User $user */
            $user = $form->getData();
            $user->setRoles(['ROLE_USER']);
            $user->setConfirmed(false);


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();




            $user_code = new ConfirmRegisterCodeService();
            $user_code2 = $user_code->setConfirmCode($user);

            $em->persist($user_code2);
            $em->flush();

            $this->addFlash('success', 'Welcome '.$user->getEmail());
            return $this->get('security.authentication.guard_handler')
              ->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $this->get('app.security.login_form_authenticator'),
                'main'
              );
        }

        return $this->render(
          'user/register.html.twig',
          [
            'form' => $form->createView(),
          ]
        );
    }

    /**
     * @Route("/emailconfirm/{id}", name="email_confirm")
     */
    public function EmailconfirmAction(Request $request, User $user)
    {

        $form = $this->createForm(EmailConfirm::class);
        $form->handleRequest($request);
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $confirm_code_from_db = $em->getRepository(
              'AppBundle:ConfirmRegisterCode'
            )
              ->findOneBy(['user' => $user]);

            $confirm_code_from_form = $form->getData();

            $RegisterCode = New ConfirmRegisterCodeService();

            if ($RegisterCode->isRegisterCodeValid(
              $confirm_code_from_db,
              $confirm_code_from_form
            )) {

                $RegisterCode->ChangeConfirmStatus($user, true);

                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Email Confirmed');

                return $this->render(
                  'user/emailconfirm.html.twig',
                  [
                    'form' => $form->createView(),
                  ]
                );
            }

        }


        $this->addFlash('success', 'nope');

        return $this->render(
          'user/emailconfirm.html.twig',
          [
            'form' => $form->createView(),
          ]
        );
    }
}