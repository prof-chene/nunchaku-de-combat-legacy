<?php

namespace Application\Sonata\UserBundle\Controller;

use Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class RegistrationFOSUser1Controller
 *
 * @package Application\Sonata\UserBundle\Controller
 */
class RegistrationFOSUser1Controller extends \Sonata\UserBundle\Controller\RegistrationFOSUser1Controller
{
    /**
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function registerAction()
    {
        $user = $this->getUser();
        if ($user instanceof UserInterface) {
            $this->container->get('session')->getFlashBag()->set('info', 'user.already_authenticated');

            return new RedirectResponse($this->container->get('router')->generate('homepage'));
        }

        $form = $this->get('sonata.user.registration.form');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
        if ($this->get('sonata.user.registration.form.handler')->process($confirmationEnabled)) {
            $user = $form->getData();

            $authUser = false;
            if ($confirmationEnabled) {
                $this->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $url = $this->generateUrl('fos_user_registration_check_email');
            } else {
                $authUser = true;
                $route = $this->get('session')->get('sonata_basket_delivery_redirect');

                if (null !== $route) {
                    $this->get('session')->remove('sonata_basket_delivery_redirect');
                    $url = $this->generateUrl($route);
                } else {
                    $url = $this->get('session')->get('sonata_user_redirect_url');
                }

                if (null === $route) {
                    $url = $this->generateUrl('sonata_user_profile_show');
                }
            }

            $this->setFlash('success', 'user.create.success');

            $response = new RedirectResponse($url);

            if ($authUser) {
                $this->authenticateUser($user, $response);
            }

            return $response;
        }

        $this->get('session')->set('sonata_user_redirect_url', $this->get('request')->headers->get('referer'));

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Template
     *
     * @return array
     *
     * @throws NotFoundHttpException
     */
    public function checkEmailAction()
    {
        $email = $this->get('session')->get('fos_user_send_confirmation_email/email');
        $user = $this->get('fos_user.user_manager')->findUserByEmail($email);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }

        return array(
            'user' => $user,
        );
    }

    /**
     * Receive the confirmation token from user email provider, login the user.
     *
     * @param string $token
     *
     * @return RedirectResponse
     *
     * @throws NotFoundHttpException
     */
    public function confirmAction($token)
    {
        $user = $this->get('fos_user.user_manager')->findUserByConfirmationToken($token);
        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }
        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());
        $this->get('fos_user.user_manager')->updateUser($user);
        if ($redirectRoute = $this->container->getParameter('sonata.user.register.confirm.redirect_route')) {
            $this->setFlash(
                'success',
                $this->get('translator')->trans('registration.confirmed', array('%username%' => $user->getUsername()))
            );
            $response = $this->redirect(
                $this->generateUrl($redirectRoute, $this->container->getParameter('sonata.user.register.confirm.redirect_route_params'))
            );
        } else {
            $response = $this->redirect($this->generateUrl('sonata_user_registration_confirmed'));
        }
        $this->authenticateUser($user, $response);

        return $response;
    }

    /**
     * Tell the user his account is now confirmed.
     *
     * @Template
     *
     * @return array
     */
    public function confirmedAction()
    {
        $user = $this->getUser();

        return array(
            'user' => $user,
        );
    }
}
