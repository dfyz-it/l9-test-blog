<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 13/07/18
 * Time: 16:15
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostController extends Controller {

  /**
   * @Route("/{category_code}/posts", name="category_show_posts")
   * @Method("GET")
   */
  public function getPostAction() {

    $em = $this->getDoctrine()->getManager();

    $posts = $em->getRepository('AppBundle:Post')
      ->findAll();

//    dump($posts);die();
    return $this->render('blog/posts.html.twig', [
      'posts' => $posts,
    ]);
  }



  //  /**
  //   * @Route("/genus/{name}/notes", name="genus_show_notes")
  //   * @Method("GET")
  //   */
  //
  //  public function getNotesAction(Genus $genus) {
  //    foreach ($genus->getNotes() as $note) {
  //      $notes[] = [
  //        'id' => $note->getId(),
  //        'username' => $note->getUsername(),
  //        'avatarUri' => '/images/' . $note->getUserAvatarFilename(),
  //        'note' => $note->getNote(),
  //        'date' => $note->getCreatedAt()->format('M d, Y'),
  //      ];
  //    }
  //
  //    $data = [
  //      'notes' => $notes,
  //    ];
  //
  //    return new JsonResponse($data);
  //  }
}