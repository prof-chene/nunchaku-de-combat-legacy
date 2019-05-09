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
        return array();
    }
}
