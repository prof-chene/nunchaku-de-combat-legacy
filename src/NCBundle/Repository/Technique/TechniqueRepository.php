<?php

namespace NCBundle\Repository\Technique;

use Doctrine\ORM\EntityRepository;

/**
 * Class TechniqueRepository
 * @package NCBundle\Repository
 */
class TechniqueRepository extends EntityRepository
{
    /**
     * @param string $slug
     *
     * @return mixed
     */
    public function findByCollectionSlug($slug)
    {
        $qb = $this
            ->createQueryBuilder('technique')
            ->join('technique.collection', 'collection')
            ->andWhere('collection.slug = :slug')
            ->andWhere('collection.enabled = true')
            ->andWhere('technique.enabled = true')
            ->andWhere('technique.publicationDateStart < CURRENT_TIMESTAMP()')
            ->setParameter('slug', $slug)
            ->addOrderBy('technique.publicationDateStart', 'DESC')
            ->addOrderBy('technique.id');

        return $qb->getQuery()->getResult();
    }
}
