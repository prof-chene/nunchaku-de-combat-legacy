<?php

namespace NCBundle\Repository\Technique;

use Doctrine\ORM\EntityRepository;

/**
 * Class ExerciseRepository
 * @package NCBundle\Repository\Technique
 */
class ExerciseRepository extends EntityRepository
{
    /**
     * @param string $slug
     *
     * @return mixed
     */
    public function findByCollectionSlug($slug)
    {
        $qb = $this
            ->createQueryBuilder('exercise')
            ->join('exercise.collection', 'collection')
            ->andWhere('collection.slug = :slug')
            ->andWhere('collection.enabled = true')
            ->andWhere('exercise.enabled = true')
            ->andWhere('exercise.publicationDateStart < CURRENT_TIMESTAMP()')
            ->setParameter('slug', $slug)
            ->addOrderBy('exercise.publicationDateStart', 'DESC')
            ->addOrderBy('exercise.id');

        return $qb->getQuery()->getResult();
    }
}
