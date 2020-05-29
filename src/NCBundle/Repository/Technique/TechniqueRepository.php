<?php

namespace NCBundle\Repository\Technique;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use NCBundle\Entity\Technique\Technique;

/**
 * Class TechniqueRepository
 */
class TechniqueRepository extends ServiceEntityRepository
{
    /**
     * @inheritdoc
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Technique::class);
    }

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
            ->addOrderBy('technique.publicationDateStart', Criteria::DESC)
            ->addOrderBy('technique.id');

        return $qb->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->getResult();
    }
}
