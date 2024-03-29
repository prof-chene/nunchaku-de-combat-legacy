<?php

namespace NCBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use NCBundle\Entity\Technique\Rank;
use NCBundle\Entity\Technique\Style;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class RankController
 */
class RankController extends Controller
{
    /**
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        $styles = $this->get('doctrine.orm.entity_manager')->getRepository(Style::class)
            ->createQueryBuilder('style')
            ->andWhere('style.enabled = true')
            ->andWhere('style.publicationDateStart < CURRENT_TIMESTAMP()')
            ->addOrderBy('style.publicationDateStart', Criteria::DESC)
            ->addOrderBy('style.id')
            ->getQuery()->getResult();

        return ['styles' => $styles];
    }

    /**
     * @Template
     *
     * @param string $slug
     *
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function viewStyleAction($slug)
    {
        $style = $this->get('doctrine.orm.entity_manager')->getRepository(Style::class)
            ->createQueryBuilder('style')
            ->leftJoin(
                'style.ranks',
                'ranks',
                Join::WITH,
                'ranks.enabled = true and ranks.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('style.enabled = true')
            ->andWhere('style.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('style.slug = :slug')
            ->setParameter('slug', $slug)
            ->addOrderBy('ranks.level', Criteria::ASC)
            ->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->getOneOrNullResult();

        if (empty($style)) {
            throw new NotFoundHttpException('This style does not exists');
        }

        return ['style' => $style,];
    }

    /**
     * @Template
     *
     * @param string $styleSlug
     * @param string $rankSlug
     *
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function viewAction($styleSlug, $rankSlug)
    {
        $rank = $this->get('doctrine.orm.entity_manager')->getRepository(Rank::class)
            ->createQueryBuilder('rank')
            ->join('rank.style', 'style')
            ->andWhere('style.enabled = true')
            ->andWhere('style.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('style.slug = :styleSlug')
            ->setParameter('styleSlug', $styleSlug)
            ->andWhere('rank.enabled = true')
            ->andWhere('rank.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('rank.slug = :rankSlug')
            ->setParameter('rankSlug', $rankSlug)
            ->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->getOneOrNullResult();

        if (empty($rank)) {
            throw new NotFoundHttpException('This rank does not exists');
        }

        return ['rank' => $rank,];
    }
}
