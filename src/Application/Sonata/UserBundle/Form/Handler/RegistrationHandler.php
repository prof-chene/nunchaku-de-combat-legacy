<?php

namespace Application\Sonata\UserBundle\Form\Handler;

use FOS\UserBundle\Model\UserInterface;
use Sonata\UserBundle\Form\Handler\RegistrationFormHandler;

/**
 * Class RegistrationFormHandler
 * @package Application\Sonata\UserBundle\Form\Handler
 */
class RegistrationHandler extends RegistrationFormHandler
{
    /**
     * @param UserInterface $user
     * @param bool $confirmation
     */
    protected function onSuccess(UserInterface $user, $confirmation)
    {
        $user->setLocale($this->request->getLocale());
        parent::onSuccess($user, $confirmation);
    }
}
