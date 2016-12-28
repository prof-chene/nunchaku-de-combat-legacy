<?php

namespace Application\Sonata\UserBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class RegistrationController
 *
 * @package Application\Sonata\UserBundle\Controller
 */
class RegistrationController extends Controller
{
    /**
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function registerAction()
    {
        if ($this->isAuthenticated()) {
            return $this->redirectIfAlreadyAuthenticated();
        }

        $form = $this->get('application_sonata_user.registration.form');
        $confirmationEnabled = $this->getParameter('fos_user.registration.confirmation.enabled');
        if ($this->get('application_sonata_user.registration.form.handler')->process($confirmationEnabled)) {
            if ($confirmationEnabled) {
                $response =  $this->redirect($this->generateUrl('application_sonata_user_registration_check_email'));
            } else {
                $response = $this->redirect($this->generateUrl('sonata_user_profile_show'));
                // Auto log-in
                $this->get('fos_user.security.login_manager')->loginUser(
                    $this->getParameter('fos_user.firewall_name'),
                    $form->getData(),
                    $response
                );
            }

            return $response;
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function checkEmailAction()
    {
        if ($this->isAuthenticated()) {
            return $this->redirectIfAlreadyAuthenticated();
        }

        // No email address in session = no registration done
        if (!$this->get('session')->has('registration/email')) {
            return $this->redirect($this->generateUrl('application_sonata_user_registration_register'));
        }

        $email = $this->get('session')->get('registration/email');
        $this->get('session')->remove('registration/email');

        return array(
            'email' => $email,
        );
    }

    /**
     * @param $token
     *
     * @return RedirectResponse
     */
    public function confirmAction($token)
    {
        if ($this->isAuthenticated()) {
            return $this->redirectIfAlreadyAuthenticated();
        }

        $user = $this->get('fos_user.user_manager')->findUserByConfirmationToken($token);
        // Invalid token
        if (!$user instanceof User) {
            $this->addFlash('danger', 'registration.invalid_link');

            return $this->redirect($this->generateUrl('application_sonata_user_registration_register'));
        }
        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $this->get('fos_user.user_manager')->updateUser($user);
        $this->addFlash('success', $this->get('translator')->trans(
            'registration.confirmed', array('%username%' => $user->getUsername())
        ));

        return $this->authenticateUser($user);
    }
}
