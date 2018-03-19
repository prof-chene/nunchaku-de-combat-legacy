<?php

namespace NCBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use NCBundle\Entity\Event\Competition;
use NCBundle\Entity\Event\Participant;
use NCBundle\Form\Type\Event\ParticipantType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CompetitionController
 * @package NCBundle\Controller
 */
class CompetitionController extends Controller
{
    /**
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        $futureCompetitions = $this->get('doctrine.orm.entity_manager')->getRepository(Competition::class)
            ->createQueryBuilder('competition')
            ->andWhere('competition.enabled = true')
            ->andWhere('competition.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('competition.startDate > CURRENT_TIMESTAMP()')
            ->addOrderBy('competition.startDate')
            ->addOrderBy('competition.id')
            ->getQuery()->getResult();

        $pastCompetitions = $this->get('doctrine.orm.entity_manager')->getRepository(Competition::class)
            ->createQueryBuilder('competition')
            ->andWhere('competition.enabled = true')
            ->andWhere('competition.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('competition.startDate <= CURRENT_TIMESTAMP()')
            ->addOrderBy('competition.startDate', Criteria::DESC)
            ->addOrderBy('competition.id')
            ->getQuery()->getResult();

        return [
            'futureCompetitions' => $futureCompetitions,
            'pastCompetitions'   => $pastCompetitions,
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
        $competition = $this->get('doctrine.orm.entity_manager')->getRepository(Competition::class)
            ->createQueryBuilder('competition')
            ->andWhere('competition.enabled = true')
            ->andWhere('competition.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('competition.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()->getOneOrNullResult();

        if (empty($competition)) {
            throw new NotFoundHttpException('This competition does not exists');
        }

        return [
            'competition' => $competition,
            'finished'    => $competition->getStartDate() <= new \DateTime(),
        ];
    }

    /**
     * @Template
     *
     * @param Request $request
     * @param $slug
     *
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function signUpAction(Request $request, $slug)
    {
        $competition = $this->get('doctrine.orm.entity_manager')->getRepository(Competition::class)
            ->createQueryBuilder('competition')
            ->andWhere('competition.enabled = true')
            ->andWhere('competition.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('competition.startDate > CURRENT_TIMESTAMP()')
            ->andWhere('competition.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()->getOneOrNullResult();

        if (empty($competition)) {
            throw new NotFoundHttpException('This competition does not exists or is already finished');
        }

        $participant = new Participant();
        $participant->setEvent($competition);

        $form = $this->createForm(ParticipantType::class, $participant);

        $this->get('nc.competition.sign_up.form.handler')->process($form);

        return [
            'competition' => $competition,
            'form'        => $form->createView(),
        ];
    }
}
