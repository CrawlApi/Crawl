<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/15
 * Time: 上午10:26
 */

namespace Crawl\CommonBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class PersistEventListener
 * @package Crawl\CommonBundle\EventListener
 */
class PersistEventListener implements EventSubscriber
{
    use ContainerAwareTrait;

    /** @var \Doctrine\ORM\EntityManager $em */
    private $em;

    /**
     * @var
     */
    private $entity;

    /**
     * @var
     */
    private $now;

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'prePersist',
            'postUpdate',
            'perUpdate',
            'perRemove',
            'postRemove'
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preAction(LifecycleEventArgs $args)
    {
        $this->now = new \DateTime();
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        $this->entity = $args->getObject();
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->preAction($args);
        $entity = $this->entity;
        $this->setAt($entity);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->preAction($args);
        $entity = $this->entity;
        $this->setAt($entity);

    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->preAction($args);
        $entity = $this->entity;
        $this->setAt($entity);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function perUpdate(LifecycleEventArgs $args)
    {
        $this->preAction($args);
        $entity = $this->entity;
        $this->setAt($entity);
    }

    /**
     * @param \Crawl\CommonBundle\Entity\Word | \Crawl\CommonBundle\Entity\WordCollins $entity
     */
    public function setAt($entity)
    {
        if (method_exists($entity, 'getCreatedAt')) {
            $entity->setCreatedAt($this->now);
        }
        if (method_exists($this->entity, 'getUpdatedAt')) {
            $entity->setUpdatedAt($this->now);
        }
    }

}