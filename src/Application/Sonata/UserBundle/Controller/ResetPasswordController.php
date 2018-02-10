<?php

namespace Application\Sonata\UserBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Application\Sonata\UserBundle\Form\Type\ResettingType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class ResetPasswordController
 *
 * @package Application\Sonata\UserBundle\Controller
 */
class ResetPasswordController extends Controller
{
    /**
     * @param Request $request
     *
     * @Template
     *
     * @return array
     */
    public function requestAction(Request $request)
    {
        if ($this->isAuthenticated()) {
            return $this->redirectIfAlreadyAuthenticated();
        }

        $form = $this->get('application_sonata_user.reset_password_request.form');
        if ($this->get('application_sonata_user.reset_password_request.form.handler')->process()) {
            return $this->redirect($this->generateUrl('application_sonata_user_reset_password_check_email'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Template
     *
     * @return array
     */
    public function checkEmailAction()
    {
        if ($this->isAuthenticated()) {
            return $this->redirectIfAlreadyAuthenticated();
        }

        // No email address in session = no password-reset requested
        if (!$this->get('session')->has('reset_password/email')) {
            return $this->redirect($this->generateUrl('application_sonata_user_reset_password_request'));
        }
        $email = $this->get('session')->get('reset_password/email');
        $this->get('session')->remove('reset_password/email');

        return array(
            'email' => $email,
        );
    }

    /**
     * @param $token
     *
     * @Template
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function resetAction($token)
    {
        if ($this->isAuthenticated()) {
            return $this->redirectIfAlreadyAuthenticated();
        }

        $user = $this->get('fos_user.user_manager')->findUserByConfirmationToken($token);
        // Invalid token
        if (!$user instanceof User) {
            $this->addFlash('danger', 'reset_password.invalid_link');

            return $this->redirect($this->generateUrl('application_sonata_user_reset_password_request'));
        }
        // Token expired
        if (!$user->isPasswordRequestNonExpired($this->getParameter('fos_user.resetting.token_ttl'))) {
            $this->addFlash('danger', 'reset_password.expired_link');

            return $this->redirect($this->generateUrl('application_sonata_user_reset_password_request'));
        }

        $form = $this->get('application_sonata_user.reset_password.form');
        if ($this->get('application_sonata_user.reset_password.form.handler')->process($user)) {
            $this->addFlash('success', 'reset_password.success');

            return $this->authenticateUser($user);
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
