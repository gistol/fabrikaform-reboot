<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Media::class);
    }

    /**
     * Get previous and next medias
     *
     * @param int $id
     *
     * @return Array Array with previous and next media IDs.
     * {
     *     'previous' => (null|int) 12
     *     'next'     => (null|int) 14
     *  }
     */
    public function getNeighbours($id = null)
    {
        $expr = $this->_em->getExpressionBuilder();
        $next = $this->createQueryBuilder('a')
            ->select($expr->min('a.id'))
            ->where($expr->gt('a.id', ':id'));
        $previous = $this->createQueryBuilder('b')
            ->select($expr->max('b.id'))
            ->where($expr->lt('b.id', ':id'));
        $query = $this->createQueryBuilder('o')
            ->select('COUNT(o) as total')
            ->addSelect('(' . $previous->getDQL() . ') as previous')
            ->addSelect('(' . $next->getDQL() . ') as next')
            ->setParameter('id', $id)
            ->getQuery();

        /**
         * optionally enable caching
         * $query->useQueryCache(true)->useResultCache(true, 3600);
         */

        $data = $query->getScalarResult();
        return array(
            'previous' => $data[0]['previous'],
            'next' => $data[0]['next']
        );
    }

}
