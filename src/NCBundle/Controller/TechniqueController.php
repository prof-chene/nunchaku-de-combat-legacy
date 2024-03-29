<?php

namespace NCBundle\Controller;

use Application\Sonata\ClassificationBundle\Entity\Collection;
use Application\Sonata\ClassificationBundle\Entity\Context;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use NCBundle\Entity\Technique\Technique;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TechniqueController
 */
class TechniqueController extends Controller
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
            ->setParameter('context', Context::TECHNIQUE_CONTEXT)
            ->andWhere('collection.enabled = :enabled')
            ->setParameter('enabled', true)
            ->join(Technique::class, 'technique', Join::WITH, 'technique.collection = collection')
            ->andWhere('technique.enabled = true')
            ->andWhere('technique.publicationDateStart < CURRENT_TIMESTAMP()')
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
        $techniques = $this->get('doctrine.orm.entity_manager')->getRepository(Technique::class)
            ->findByCollectionSlug($slug);

        if (empty($techniques)) {
            throw new NotFoundHttpException('No result found');
        }

        return ['techniques' => $techniques,];
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
        $technique = $this->get('doctrine.orm.entity_manager')->getRepository(Technique::class)
            ->createQueryBuilder('technique')
            ->andWhere('technique.enabled = true')
            ->andWhere('technique.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('technique.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->getOneOrNullResult();

        if (empty($technique)) {
            throw new NotFoundHttpException('This technique does not exists');
        }

        return ['technique' => $technique,];
    }
}
