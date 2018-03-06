<?php

namespace NCBundle\Controller;

use NCBundle\Entity\Technique\Technique;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class TechniqueController
 * @package NCBundle\Controller
 */
class TechniqueController extends Controller
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Template
     *
     * @param $slug
     *
     * @return array
     */
    public function collectionViewAction($slug)
    {
        $techniques = $this->get('doctrine.orm.entity_manager')->getRepository(Technique::class)
            ->findByCollectionSlug($slug);

        return ['techniques' => $techniques,];
    }

    /**
     * @Template
     *
     * @param $slug
     *
     * @return array
     */
    public function viewAction($slug)
    {
        $technique = $this->get('doctrine.orm.entity_manager')->getRepository(Technique::class)
            ->findOneBy(['slug' => $slug]);

        return ['technique' => $technique,];
    }
}
