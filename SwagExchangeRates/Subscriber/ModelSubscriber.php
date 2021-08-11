<?php declare(strict_types = 1);

namespace SwagExchangeRates\Subscriber;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Shopware\Models\Article\Article;
use Doctrine\ORM\Events;

/**
 * Class ModelSubscriber
 * @package SwagExchangeRates\Subscriber
 */
class ModelSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::preUpdate,
            Events::postUpdate,
        ];
    }

    public function preUpdate(LifecycleEventArgs $arguments):void
    {
        $entity = $arguments->getObject();
        if (!$entity instanceof Product) {
            return;
        }

        $entityManager = $arguments->getObjectManager();
        print_r($entityManager);

    }
    public function postUpdate(LifecycleEventArgs $arguments)
    {
        $entity = $arguments->getObject();
        $entityManager = $arguments->getObjectManager();
        if ($entity instanceof Product) {
            print_r($entity);
        }
    }
}