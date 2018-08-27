<?php

namespace Application\Sonata\UserBundle\Form\Handler;

use Sonata\UserBundle\Model\UserInterface;
use Sonata\UserBundle\Entity\UserManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ResetPasswordHandler
 */
class ResetPasswordHandler
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
     * @var UserManager
     */
    private $userManager;

    /**
     * ResetPasswordHandler constructor.
     *
     * @param FormInterface $form
     * @param RequestStack $requestStack
     * @param UserManager $userManager
     */
    public function __construct(
        FormInterface $form,
        RequestStack $requestStack,
        UserManager $userManager
    ) {
        $this->form = $form;
        $this->request = $requestStack->getCurrentRequest();
        $this->userManager = $userManager;
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function process(UserInterface $user)
    {
        if ('POST' === $this->request->getMethod()) {
            $this->form->handleRequest($this->request);
            if ($this->form->isValid()) {
                $data = $this->form->getData();
                $user->setPlainPassword($data['plainPassword']);
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
        if (!is_null($user->getConfirmationToken())) {
            $user->setConfirmationToken(null);
        }
        if (!is_null($user->getPasswordRequestedAt())) {
            $user->setPasswordRequestedAt(null);
        }
        $this->userManager->updateUser($user);
    }
}
