<?php

namespace NCFrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class HomeController
 * @package NCFrontBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return array();
    }
}
