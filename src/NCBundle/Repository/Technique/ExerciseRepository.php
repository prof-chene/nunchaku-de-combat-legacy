<?php

namespace NCBundle\Repository\Technique;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

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
            ->addOrderBy('exercise.publicationDateStart', Criteria::DESC)
            ->addOrderBy('exercise.id');

        return $qb->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->getResult();
    }
}
