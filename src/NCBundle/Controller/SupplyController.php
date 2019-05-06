<?php

namespace NCBundle\Controller;

use Application\Sonata\ClassificationBundle\Entity\Collection;
use Application\Sonata\ClassificationBundle\Entity\Context;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use NCBundle\Entity\Technique\Supply;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SupplyController
 */
class SupplyController extends Controller
{
    /**
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        $collections = $this->get('doctrine.orm.entity_manager')->getRepository(Collection::class)
            ->createQueryBuilder('collection')
            ->andWhere('collection.context = :context')
            ->setParameter('context', Context::SUPPLY_CONTEXT)
            ->andWhere('collection.enabled = :enabled')
            ->setParameter('enabled', true)
            ->join(Supply::class, 'supply', Join::WITH, 'supply.collection = collection')
            ->andWhere('supply.enabled = true')
            ->andWhere('supply.publicationDateStart < CURRENT_TIMESTAMP()')
            ->addOrderBy('collection.id', Criteria::ASC)
            ->getQuery()
            ->getResult();

        return ['collections' => $collections];
    }

    /**
     * @Template
     *
     * @param string $slug
     *
     * @return array
     */
    public function collectionViewAction($slug)
    {
        $supplies = $this->get('doctrine.orm.entity_manager')->getRepository(Supply::class)
            ->findByCollectionSlug($slug);

        if (empty($supplies)) {
            throw new NotFoundHttpException('No result found');
        }

        return ['supplies' => $supplies,];
    }

    /**
     * @Template
     *
     * @param string $slug
     *
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function viewAction($slug)
    {
        $supply = $this->get('doctrine.orm.entity_manager')->getRepository(Supply::class)
            ->createQueryBuilder('supply')
            ->andWhere('supply.enabled = true')
            ->andWhere('supply.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('supply.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->getOneOrNullResult();

        if (empty($supply)) {
            throw new NotFoundHttpException('This supply does not exists');
        }

        return ['supply' => $supply,];
    }
}
