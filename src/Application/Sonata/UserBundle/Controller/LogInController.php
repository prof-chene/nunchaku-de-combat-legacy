<?php

namespace Application\Sonata\UserBundle\Controller;

use Application\Sonata\UserBundle\Form\Type\LogInType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class LogInController
 */
class LogInController extends Controller
{
    /**
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function logInAction(Request $request)
    {
        if ($this->isAuthenticated()) {
            return $this->redirectIfAlreadyAuthenticated();
        }

        if ($request->request->has((Security::AUTHENTICATION_ERROR))) {
            $this->addFlash('danger', $request->request->get(Security::AUTHENTICATION_ERROR)->getMessage());
        } elseif ($this->get('session')->has(Security::AUTHENTICATION_ERROR)) {
            $this->addFlash('danger', $this->get('session')->get(Security::AUTHENTICATION_ERROR)->getMessage());
            $this->get('session')->remove(Security::AUTHENTICATION_ERROR);
        }
        $form = $this->createForm(LogInType::class, null, array(
            'action' => $this->container->get('router')->generate('application_sonata_user_log_in_check'),
        ));

        return array(
            'form' => $form->createView(),
        );
    }

    public function loginCheckAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logOutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}
