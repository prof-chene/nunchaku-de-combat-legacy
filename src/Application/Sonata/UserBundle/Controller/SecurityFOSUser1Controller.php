<?php

namespace Application\Sonata\UserBundle\Controller;

use Application\Sonata\UserBundle\Form\Type\LoginType;
use Sonata\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class SecurityFOSUser1Controller
 * @package Application\Sonata\UserBundle\Controller
 */
class SecurityFOSUser1Controller extends Controller
{
    /**
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function loginAction()
    {
        $user = $this->getUser();
        if ($user instanceof UserInterface) {
            $this->container->get('session')->getFlashBag()->set('info',
                $this->get('translator')->trans('sonata_user_already_authenticated', array(), 'SonataUserBundle'));

            return new RedirectResponse($this->container->get('router')->generate('homepage'));
        }

        if ($this->container->get('request')->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $this->container->get('session')->getFlashBag()->set('danger',
                $this->container->get('request')->attributes->get(Security::AUTHENTICATION_ERROR)->getMessage());
        } else if ($this->container->get('session')->has(Security::AUTHENTICATION_ERROR)) {
            $this->container->get('session')->getFlashBag()->set('danger',
                $this->container->get('session')->get(Security::AUTHENTICATION_ERROR)->getMessage());
            $this->container->get('session')->remove(Security::AUTHENTICATION_ERROR);
        }

        return array();
    }

    /**
     * @Template()
     *
     * @return array
     */
    public function loginFormAction()
    {
        $form = $this->container->get('form.factory')->create(LoginType::class, null, array(
            'action' => $this->container->get('router')->generate('sonata_user_security_check'),
        ));

        return array(
            'form' => $form->createView(),
        );
    }
}
