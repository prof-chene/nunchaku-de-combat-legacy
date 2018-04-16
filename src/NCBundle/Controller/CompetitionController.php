<?php

namespace NCBundle\Controller;

use NCBundle\Entity\Event\Competition;
use NCBundle\Entity\Event\Participant;
use NCBundle\Form\Type\Event\ParticipantType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        $competitions = $this->get('doctrine.orm.entity_manager')->getRepository(Competition::class)
            ->createRegistrationQueryBuilder($this->getUser())->getQuery()->getResult();

        return [
            'competitions' => $competitions,
        ];
    }

    /**
     * @Template
     *
     * @param string $slug
     *
     * @return array
     */
    public function viewAction($slug)
    {
        $competition = $this->get('doctrine.orm.entity_manager')->getRepository(Competition::class)
            ->createRegistrationQueryBuilder($this->getUser(), $slug)->getQuery()->getOneOrNullResult();

        if (empty($competition)) {
            throw new NotFoundHttpException('This competition does not exists');
        }

        return ['competition' => $competition,];
    }

    /**
     * @Template
     *
     * @param string$slug
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function signUpAction($slug)
    {
        $competition = $this->get('doctrine.orm.entity_manager')->getRepository(Competition::class)
            ->createRegistrationQueryBuilder($this->getUser(), $slug)->getQuery()->getOneOrNullResult();

        if (empty($competition)) {
            throw new NotFoundHttpException('This competition does not exists');
        }
        if ($competition['finished']) {
            throw new NotFoundHttpException('Registrations are closed for this competition');
        }

        $participant = new Participant();
        $participant->setEvent($competition[0]);

        $form = $this->createForm(ParticipantType::class, $participant, ['registered' => $competition['registered']]);

        if ($this->get('nc.form.participant.handler')->process($form)) {
            return $this->redirect($this->get('router')->generate('competition_view', ['slug' => $slug]));
        }

        return [
            'competition' => $competition[0],
            'form'        => $form->createView(),
        ];
    }
}
