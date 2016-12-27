<?php

namespace Application\Sonata\UserBundle\Form\Handler;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Sonata\UserBundle\Entity\UserManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class ResetPasswordHandler
 *
 * @package Application\Sonata\UserBundle\Form\Handler
 */
class ResetPasswordHandler
{
    /**
     * @var FormInterface
     */
    protected $form;
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Session
     */
    protected $session;
    /**
     * @var Translator
     */
    protected $translator;
    /**
     * @var UserManager
     */
    protected $userManager;
    /**
     * @var MailerInterface
     */
    protected $mailer;
    /**
     * @var TokenGeneratorInterface
     */
    protected $tokenGenerator;
    /**
     * @var string
     */
    protected $tokenTtl;

    /**
     * ResetPasswordHandler constructor.
     *
     * @param FormInterface $form
     * @param Request $request
     * @param Session $session
     * @param Translator $translator
     * @param UserManager $userManager
     * @param MailerInterface $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @param $tokenTtl
     */
    public function __construct(
        FormInterface $form,
        Request $request,
        Session $session,
        Translator $translator,
        UserManager $userManager,
        MailerInterface $mailer,
        TokenGeneratorInterface $tokenGenerator,
        $tokenTtl
    ) {
        $this->form = $form;
        $this->request = $request;
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
            $this->form->bind($this->request);
            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $user = $this->userManager->findUserByUsernameOrEmail($data['username_email']);
                if (!$user->isEnabled()) {
                    $this->session->getFlashBag()->set('danger', 'user.is_disabled');

                    return false;
                }
                if ($user->isPasswordRequestNonExpired($this->tokenTtl)) {
                    $this->session->getFlashBag()->set('danger', $this->translator->trans(
                        'reset_password.already_requested',
                        array('%hours%' => $this->tokenTtl/3600)
                    ));

                    return false;
                }
                $this->onSuccess($user);

                return true;
            }
        }

        return false;
    }

    protected function onSuccess(UserInterface $user)
    {
        if (is_null($user->getConfirmationToken())) {
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
        }
        $this->mailer->sendResettingEmailMessage($user);
        $this->session->set('fos_user_send_resetting_email/email', $user->getEmail());
        $user->setPasswordRequestedAt(new \DateTime());
        $this->userManager->save($user);
    }

    /**
     * @return UserInterface
     */
    protected function createUser()
    {
        return $this->userManager->createUser();
    }
}
