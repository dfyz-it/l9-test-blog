<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 19/07/18
 * Time: 13:31
 */

namespace AppBundle\Doctrine;


use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\User;
// TODO: unused imports should be removed
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

// TODO: PHPDoc should be used for all classes, properties and methods (at least public)
class HashPasswordListener implements EventSubscriber
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            return;
        }

        $this->encodePassword($entity);
    }


    // TODO: there is no possibility to update password, so preUpdate listener could be removed
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            return;
        }
        $this->encodePassword($entity);
        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }


    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }

    /**
     * @param User $entity
     */
    private function encodePassword(User $entity)
    {
        if (!$entity->getPlainPassword()) {
            return;
        }
        $encoded = $this->passwordEncoder->encodePassword(
          $entity,
          $entity->getPlainPassword()
        );
        $entity->setPassword($encoded);
    }
}