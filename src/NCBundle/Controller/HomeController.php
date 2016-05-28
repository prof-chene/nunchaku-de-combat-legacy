<?php

namespace NCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class HomeController
 * @package NCBundle\Controller
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
