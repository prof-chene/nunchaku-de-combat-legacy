<?php

namespace NCBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use NCBundle\Entity\Technique\Supply;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SupplyController
 * @package NCBundle\Controller
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
        $supplies = $this->get('doctrine.orm.entity_manager')->getRepository(Supply::class)
            ->createQueryBuilder('supply')
            ->andWhere('supply.enabled = true')
            ->andWhere('supply.publicationDateStart < CURRENT_TIMESTAMP()')
            ->addOrderBy('supply.publicationDateStart', Criteria::DESC)
            ->addOrderBy('supply.id')
            ->getQuery()->getResult();

        return ['supplies' => $supplies];
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
            ->getQuery()->getOneOrNullResult();

        if (empty($supply)) {
            throw new NotFoundHttpException('This supply does not exists');
        }

        return ['supply' => $supply,];
    }
}
