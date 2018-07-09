<?php

namespace NCBundle\Controller;

use Doctrine\ORM\Query;
use Gedmo\Translatable\TranslatableListener;
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
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->setHint(TranslatableListener::HINT_INNER_JOIN, true)
            ->getResult();

        return [
            'clubs' => $clubs,
        ];
    }
}
