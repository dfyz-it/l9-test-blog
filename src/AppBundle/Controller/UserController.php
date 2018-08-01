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


    private $confirmregistercode;


    public function __construct(ConfirmRegisterCodeService $confirmregistercode)
    {
        $this->confirmregistercode = $confirmregistercode;
    }


    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request, \Swift_Mailer $mailer)
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

            $user_code = $this->getConfirmregistercode()->createConfirmCode(
              $user
            );
            $em->persist($user_code);
            $em->flush();

            $message = (new \Swift_Message('Hello Email'))
              ->setFrom('send@example.com')
              ->setTo('recipient@example.com')
              ->setBody(
                $this->renderView(
                  'emails/ConfirmMail.html.twig',
                  array(
                    'name' => $user->getName(),
                    'id' => $user->getId(),
                    'code' => $user_code->getConfirmCode(),
                  )
                ),
                'text/html'
              );

            $mailer->send($message);


            $this->addFlash(
              'success',
              'Confirm you email from mail '.$user->getEmail()
            );

           return $this->redirectToRoute('homepage');

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

            if ($this->getConfirmregistercode()->isRegisterCodeValid(
              $confirm_code_from_db,
              $confirm_code_from_form
            )) {

                $this->getConfirmregistercode()->ChangeConfirmStatus(
                  $user,
                  true
                );

                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Email Confirmed');

                return $this->get('security.authentication.guard_handler')
                  ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main'
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

    public function SendConfirmCode(User $user)
    {

        //        $message = (new \Swift_Message('Hello Email'))
        //          ->setFrom('send@example.com')
        //          ->setTo('recipient@example.com')
        //          ->setBody(
        //            $this->renderView(
        //              'emails/ConfirmMail.html.twig',
        //              array(
        //                'name' => 1,
        //                'id' => 1,
        //                'code' => 1,
        //              )
        //            ),
        //            'text/html'
        //          );
        //
        //        $mailer->send($message);

        return;
    }


    /**
     * @return \AppBundle\Service\ConfirmRegisterCodeService
     */
    public function getConfirmregistercode()
    {
        return $this->confirmregistercode;
    }


}