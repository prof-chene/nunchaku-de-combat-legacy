<?php

namespace NCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HomeController
 */
class HomeController extends Controller
{
    /**
     * @param Request $request
     *
     * @Template
     *
     * @return array|RedirectResponse
     */
    public function indexAction(Request $request)
    {
        /* This redirects https://mydomain.com/DEFAULT_LOCALE to https://mydomain.com to have a prettier homepage url
           and avoid duplicate-content */
        if ($request->attributes->get('_locale') === $this->getParameter('locale')) {
            return $this->redirectToRoute('homepage', [], 301);
        }

        return array();
    }
}
