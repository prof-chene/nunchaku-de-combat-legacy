<?php

namespace NCBundle\Event;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

/**
 * Class AuthenticationListener
 */
class AuthenticationListener implements LogoutSuccessHandlerInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * AuthenticationListener constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @inheritdoc
     */
    public function onLogoutSuccess(Request $request)
    {
        return new RedirectResponse(
            $this->router->generate('homepage_localized', ['_locale' => $request->getLocale()])
        );
    }
}
