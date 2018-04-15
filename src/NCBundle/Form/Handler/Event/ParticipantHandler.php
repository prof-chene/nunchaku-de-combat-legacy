<?php

namespace NCBundle\Form\Handler\Event;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use NCBundle\Entity\Event\TrialResult;
use NCBundle\Service\Mailer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ParticipantType
 *
 * @package NCBundle\Form\Event
 */
class ParticipantHandler
{
    /**
     * @var RequestStack
     */
    private $request;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var Session
     */
    private $session;

    /**
     * ParticipantHandler constructor.
     *
     * @param RequestStack          $requestStack
     * @param TokenStorageInterface $tokenStorage
     * @param EntityManager         $entityManager
     * @param Mailer                $mailer
     * @param Session               $session
     */
    public function __construct(
        RequestStack $requestStack,
        TokenStorageInterface $tokenStorage,
        EntityManager $entityManager,
        Mailer $mailer,
        Session $session
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->session = $session;
    }

    /**
     * @param FormInterface $form
     *
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function process(FormInterface $form)
    {
        if ('POST' === $this->request->getMethod()) {
            $form->handleRequest($this->request);
            if ($form->isValid()) {
                $participant = $form->getData();
                if ($this->tokenStorage->getToken()->getUser() instanceof User) {
                    $participant->setRegistrant($this->tokenStorage->getToken()->getUser());
                    if ($form->has('itsMe') && $form->get('itsMe')->getData()) {
                        $participant->setUser($this->tokenStorage->getToken()->getUser());
                    }
                }
                $this->entityManager->persist($participant);
                $this->entityManager->flush($participant);
                if (!empty($form->get('trials')->getData())) {
                    $trials = $form->get('trials')->getData();
                    foreach ($trials as $trial) {
                        $trialResult = new TrialResult();
                        $trialResult->setTrial($trial);
                        $participant->addTrialResult($trialResult);
                    }
                }
                $this->entityManager->flush($participant);

                if (!empty($participant->getRegistrant())) {
                    $templateParams = [
                        'registrant'  => $participant->getRegistrant(),
                        'event'       => $participant->getEvent(),
                        'participant' => $participant,
                    ];
                    if (!empty($participant->getTrialResults())) {
                        $trialNames = [];
                        foreach ($participant->getTrialResults() as $trialResult) {
                            $trialNames[] = $trialResult->getTrial()->getName();
                        }
                        $templateParams['trials'] = $trialNames;
                    }
                    $this->mailer->sendFromTemplate(
                        ':Email/Event:event_subscribed.txt.twig',
                        $templateParams,
                        $participant->getRegistrant()->getEmail()
                    );
                }

                $this->session->getFlashBag()->add('success', 'registration.success');

                return true;
            }
        }

        return false;
    }
}
