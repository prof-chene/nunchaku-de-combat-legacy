<?php

namespace NCBundle\Form\Handler\Event;

use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use NCBundle\Entity\Event\TrialResult;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
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
     * ParticipantHandler constructor.
     *
     * @param RequestStack          $requestStack
     * @param TokenStorageInterface $tokenStorage
     * @param EntityManager         $entityManager
     */
    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, EntityManager $entityManager)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }

    /**
     * @param FormInterface $form
     *
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     */
    public function process(FormInterface $form)
    {
        if ('POST' === $this->request->getMethod()) {
            $form->handleRequest($this->request);
            if ($form->isValid()) {
                $participant = $form->getData();
                if ($this->tokenStorage->getToken()->getUser() instanceof User && $form->get('itsMe')->getData()) {
                    $participant->setUser($this->tokenStorage->getToken()->getUser());
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

                return true;
            }
        }

        return false;
    }
}
