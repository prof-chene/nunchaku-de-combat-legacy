<?php

namespace NCBundle\Repository\Technique;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use NCBundle\Entity\Technique\Exercise;

/**
 * Class ExerciseRepository
 */
class ExerciseRepository extends ServiceEntityRepository
{
    /**
     * @inheritdoc
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercise::class);
    }

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
