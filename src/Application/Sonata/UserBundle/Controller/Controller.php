<?php

namespace Application\Sonata\UserBundle\Controller;

use Application\Sonata\UserBundle\Entity\User;
use Sonata\UserBundle\Model\UserInterface;

/**
 * Class Controller
 *
 * @package Application\Sonata\UserBundle\Controller
 */
class Controller extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectIfAlreadyAuthenticated()
    {
        if ($this->isAuthenticated()) {
            $this->addFlash('info', 'user.already_authenticated');

            return $this->redirect($this->generateUrl('homepage'));
        }
    }

    /**
     * @return bool
     */
    protected function isAuthenticated()
    {
        return $this->getUser() instanceof UserInterface;
    }

    /**
     * @param User $user
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function authenticateUser(User $user)
    {
        $response = $this->redirect($this->generateUrl('fos_user_profile_show'));
        $this->get('fos_user.security.login_manager')->loginUser($this->getParameter('fos_user.firewall_name'), $user, $response);
        $user->setLastLogin(new \DateTime());
        $this->get('sonata.user.user_manager')->save($user);

        return $response;
    }
}
