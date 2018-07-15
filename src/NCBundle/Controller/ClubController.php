<?php

namespace NCBundle\Controller;

use NCBundle\Entity\Information\Club;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class ClubController
 */
class ClubController extends Controller
{
    /**
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        $clubs = $this->get('doctrine.orm.entity_manager')->getRepository(Club::class)
            ->createQueryBuilder('club')
            ->andWhere('club.enabled = true')
            ->andWhere('club.publicationDateStart < CURRENT_TIMESTAMP()')
            ->getQuery()
            ->getResult();

        return [
            'clubs' => $clubs,
        ];
    }
}
