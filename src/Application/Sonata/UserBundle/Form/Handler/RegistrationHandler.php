<?php

namespace Application\Sonata\UserBundle\Form\Handler;

use Sonata\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Sonata\UserBundle\Entity\UserManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class RegistrationHandler
 *
 * @package Application\Sonata\UserBundle\Form\Handler
 */
class RegistrationHandler
{
    /**
     * @var FormInterface
     */
    private $form;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;

    /**
     * RegistrationHandler constructor.
     * @param FormInterface $form
     * @param RequestStack $requestStack
     * @param Session $session
     * @param UserManager $userManager
     * @param MailerInterface $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     */
    public function __construct(
        FormInterface $form,
        RequestStack $requestStack,
        Session $session,
        UserManager $userManager,
        MailerInterface $mailer,
        TokenGeneratorInterface $tokenGenerator
    ) {
        $this->form = $form;
        $this->request = $requestStack->getCurrentRequest();
        $this->session = $session;
        $this->userManager = $userManager;
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * @param bool $confirmation
     *
     * @return bool
     */
    public function process($confirmation = false)
    {
        if ('POST' === $this->request->getMethod()) {
            $user = $this->createUser();
            $this->form->setData($user);
            $this->form->handleRequest($this->request);
            if ($this->form->isValid()) {
                $this->onSuccess($user, $confirmation);

                return true;
            }
        }

        return false;
    }

    /**
     * @param UserInterface $user
     * @param boolean       $confirmation
     */
    private function onSuccess(UserInterface $user, $confirmation)
    {
        if ($confirmation) {
            $user->setEnabled(false);
            if (empty($user->getConfirmationToken())) {
                $user->setConfirmationToken($this->tokenGenerator->generateToken());
            }
            $this->mailer->sendConfirmationEmailMessage($user);
            $this->session->set('registration/email', $user->getEmail());
        } else {
            $user->setEnabled(true);
        }

        $this->userManager->updateUser($user);
    }

    /**
     * @return UserInterface
     */
    private function createUser()
    {
        $user = $this->userManager->createUser()->setLocale($this->request->getLocale());

        return $user;
    }
}
