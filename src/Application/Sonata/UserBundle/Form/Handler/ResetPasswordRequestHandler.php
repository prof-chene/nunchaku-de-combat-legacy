<?php

namespace Application\Sonata\UserBundle\Form\Handler;

use Sonata\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Sonata\UserBundle\Entity\UserManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class ResetPasswordRequestHandler
 */
class ResetPasswordRequestHandler
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
     * @var Translator
     */
    private $translator;
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
     * @var string
     */
    private $tokenTtl;

    /**
     * ResetPasswordHandler constructor.
     *
     * @param FormInterface $form
     * @param RequestStack $requestStack
     * @param Session $session
     * @param Translator $translator
     * @param UserManager $userManager
     * @param MailerInterface $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @param $tokenTtl
     */
    public function __construct(
        FormInterface $form,
        RequestStack $requestStack,
        Session $session,
        Translator $translator,
        UserManager $userManager,
        MailerInterface $mailer,
        TokenGeneratorInterface $tokenGenerator,
        $tokenTtl
    ) {
        $this->form = $form;
        $this->request = $requestStack->getCurrentRequest();
        $this->session = $session;
        $this->translator = $translator;
        $this->userManager = $userManager;
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->tokenTtl = $tokenTtl;
    }

    /**
     * @return bool
     */
    public function process()
    {
        if ('POST' === $this->request->getMethod()) {
            $this->form->handleRequest($this->request);
            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $user = $this->userManager->findUserByUsernameOrEmail($data['username_email']);
                if (!$user->isEnabled()) {
                    $this->session->getFlashBag()->add('danger', 'user.is_disabled');

                    return false;
                }
                // Password reset already requested in the last %tokenTtl%
                if ($user->isPasswordRequestNonExpired($this->tokenTtl)) {
                    $this->session->getFlashBag()->add('danger', $this->translator->trans(
                        'reset_password.already_requested',
                        ['%hours%' => $this->tokenTtl/3600]
                    ));

                    return false;
                }
                $this->onSuccess($user);

                return true;
            }
        }

        return false;
    }

    /**
     * @param UserInterface $user
     */
    private function onSuccess(UserInterface $user)
    {
        if (is_null($user->getConfirmationToken())) {
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
        }
        $this->mailer->sendResettingEmailMessage($user);
        $this->session->set('reset_password/email', $user->getEmail());
        $user->setPasswordRequestedAt(new \DateTime());
        $this->userManager->save($user);
    }
}
