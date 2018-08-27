<?php

namespace NCBundle\Repository\Technique;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class TechniqueRepository
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
            ->addOrderBy('technique.publicationDateStart', Criteria::DESC)
            ->addOrderBy('technique.id');

        return $qb->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->getResult();
    }
}
