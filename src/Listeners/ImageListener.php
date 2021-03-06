<?php

namespace App\Listeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use AppBundle\Entity\Image;
use AppBundle\Services\ImageTransformer;
use Vich\UploaderBundle\Event\Event;
use Doctrine\ORM\EntityManagerInterface;

/**
 * ImageListener
 */
class ImageListener
{
    private $cacheManager;
    private $path_image;
    private $orm;

    public function __construct(CacheManager $cacheManager, EntityManagerInterface $orm, string $path_image)
    {
        $this->cacheManager = $cacheManager;
        $this->path_image = $path_image;
        $this->orm = $orm;
    }

    public function onVichUploaderPreInject(Event $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Image) {
            return;
        }

        $image = $entity->getImage();
        $entity->setTmpFile($image);
        $this->orm->flush();

    }


    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Image) {
            return;
        }
        $changeSet = $args->getEntityManager()->getUnitOfWork()->getEntityChangeSet($entity);

        if (!array_key_exists("image", $changeSet)) {
            return;
        }

        try {
            $this->cacheManager->remove($this->path_image . '/' . $entity->getTmpFile());
            $this->cacheManager->resolve($this->path_image . '/' . $entity->getImage(), null);

        } catch (\Exception $e) {

        }

    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Image) {
            return;
        }

        $target = $this->path_image . '/' . $entity->getImage();
        try {
            $this->cacheManager->remove($target);
        } catch (\Exception $e) {

        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Image) {
            return;
        }
        $file = $this->path_image . '/' . $entity->getImage();
    }
}
