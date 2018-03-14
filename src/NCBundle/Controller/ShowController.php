<?php

namespace NCBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use NCBundle\Entity\Event\Show;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ShowController
 * @package NCBundle\Controller
 */
class ShowController extends Controller
{
    /**
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        $futureShows = $this->get('doctrine.orm.entity_manager')->getRepository(Show::class)
            ->createQueryBuilder('show')
            ->andWhere('show.enabled = true')
            ->andWhere('show.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('show.startDate > CURRENT_TIMESTAMP()')
            ->addOrderBy('show.startDate')
            ->addOrderBy('show.id')
            ->getQuery()->getResult();

        $pastShows = $this->get('doctrine.orm.entity_manager')->getRepository(Show::class)
            ->createQueryBuilder('show')
            ->andWhere('show.enabled = true')
            ->andWhere('show.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('show.startDate <= CURRENT_TIMESTAMP()')
            ->addOrderBy('show.startDate', Criteria::DESC)
            ->addOrderBy('show.id')
            ->getQuery()->getResult();

        return [
            'futureShows' => $futureShows,
            'pastShows'   => $pastShows,
        ];
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
        $show = $this->get('doctrine.orm.entity_manager')->getRepository(Show::class)
            ->createQueryBuilder('show')
            ->andWhere('show.enabled = true')
            ->andWhere('show.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('show.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()->getOneOrNullResult();

        if (empty($show)) {
            throw new NotFoundHttpException('This show does not exists');
        }

        return ['show' => $show,];
    }
}
