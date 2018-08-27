<?php

namespace NCBundle\Controller;

use Doctrine\ORM\Query;
use NCBundle\Entity\Event\Participant;
use NCBundle\Entity\Event\TrainingCourse;
use NCBundle\Form\Type\Event\ParticipantType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ShowController
 */
class TrainingCourseController extends Controller
{
    /**
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        $trainingCourses = $this->get('doctrine.orm.entity_manager')->getRepository(TrainingCourse::class)
            ->createRegistrationQueryBuilder($this->getUser())->getQuery()->getResult();

        return [
            'trainingCourses' => $trainingCourses,
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
        $trainingCourse = $this->get('doctrine.orm.entity_manager')->getRepository(TrainingCourse::class)
            ->createRegistrationQueryBuilder($this->getUser(), $slug)
            ->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->getOneOrNullResult();

        if (empty($trainingCourse)) {
            throw new NotFoundHttpException('This trainingCourse does not exists');
        }

        return ['trainingCourse' => $trainingCourse,];
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
        $trainingCourse = $this->get('doctrine.orm.entity_manager')->getRepository(TrainingCourse::class)
            ->createRegistrationQueryBuilder($this->getUser(), $slug)
            ->getQuery()
            ->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker')
            ->getOneOrNullResult();

        if (empty($trainingCourse)) {
            throw new NotFoundHttpException('This trainingCourse does not exists');
        }
        if ($trainingCourse['finished']) {
            throw new NotFoundHttpException('Registrations are closed for this trainingCourse');
        }

        $participant = new Participant();
        $participant->setEvent($trainingCourse[0]);

        $form = $this->createForm(ParticipantType::class, $participant, ['registered' => $trainingCourse['registered']]);

        if ($this->get('nc.form.participant.handler')->process($form)) {
            return $this->redirect($this->get('router')->generate('training_course_view', ['slug' => $slug]));
        }

        return [
            'trainingCourse' => $trainingCourse[0],
            'form' => $form->createView(),
        ];
    }
}
