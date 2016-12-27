<?php

namespace Application\Sonata\UserBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Application\Sonata\UserBundle\Form\Type\ResettingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $form = $this->get('application_sonata_user.reset_password.form');
        if ($this->get('application_sonata_user.reset_password.form.handler')->process()) {
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
        if (!$this->get('session')->has('fos_user_send_resetting_email/email')) {
            return $this->redirect($this->generateUrl('application_sonata_user_reset_password_request'));
        }
        $email = $this->get('session')->get('fos_user_send_resetting_email/email');
        $this->get('session')->remove('fos_user_send_resetting_email/email');

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
        $user = $this->get('fos_user.user_manager')->findUserByConfirmationToken($token);
        if (!$user instanceof User) {
            $this->get('session')->getFlashBag()->set('danger', 'reset_password.invalid_link');

            return $this->redirect($this->generateUrl('application_sonata_user_reset_password_request'));
        }
        if (!$user->isPasswordRequestNonExpired($this->getParameter('fos_user.resetting.token_ttl'))) {
            $this->get('session')->getFlashBag()->set('danger', 'reset_password.expired_link');

            return $this->redirect($this->generateUrl('application_sonata_user_reset_password_request'));
        }

        $form = $this->container->get('fos_user.resetting.form')->add('submit', 'submit', array(
            'label' => 'reset_password.request'
        ));
        if ($this->get('fos_user.resetting.form.handler')->process($user)) {
            $this->get('session')->getFlashBag()->add('success', 'reset_password.success');
            $response = $this->redirect($this->generateUrl('fos_user_profile_show'));
            $this->get('fos_user.security.login_manager')->loginUser($this->getParameter('fos_user.firewall_name'), $user, $response);

            return $response;
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
