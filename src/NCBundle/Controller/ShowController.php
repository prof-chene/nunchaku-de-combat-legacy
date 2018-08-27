<?php

namespace NCBundle\Controller;

use Doctrine\ORM\Query;
use NCBundle\Entity\Event\Participant;
use NCBundle\Entity\Event\Show;
use NCBundle\Form\Type\Event\ParticipantType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ShowController
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
        $shows = $this->get('doctrine.orm.entity_manager')->getRepository(Show::class)
            ->createRegistrationQueryBuilder($this->getUser())->getQuery()->getResult();

        return [
            'shows' => $shows,
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
            ->createRegistrationQueryBuilder($this->getUser(), $slug)
            ->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->getOneOrNullResult();

        if (empty($show)) {
            throw new NotFoundHttpException('This show does not exists');
        }

        return ['show' => $show,];
    }

    /**
     * @Template
     *
     * @param string $slug
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function signUpAction($slug)
    {
        $show = $this->get('doctrine.orm.entity_manager')->getRepository(Show::class)
            ->createRegistrationQueryBuilder($this->getUser(), $slug)
            ->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->getOneOrNullResult();

        if (empty($show)) {
            throw new NotFoundHttpException('This show does not exists');
        }
        if ($show['finished']) {
            throw new NotFoundHttpException('Registrations are closed for this show');
        }

        $participant = new Participant();
        $participant->setEvent($show[0]);

        $form = $this->createForm(ParticipantType::class, $participant, ['registered' => $show['registered']]);

        if ($this->get('nc.form.participant.handler')->process($form)) {
            return $this->redirect($this->get('router')->generate('show_view', ['slug' => $slug]));
        }

        return [
            'show' => $show[0],
            'form' => $form->createView(),
        ];
    }
}
