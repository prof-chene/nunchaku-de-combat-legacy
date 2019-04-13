<?php

namespace Application\Sonata\NewsBundle\Controller;

use \Sonata\NewsBundle\Controller\PostController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

/**
 * Class PostController
 */
class PostController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $pager = $this->getPostManager()->getPager(
            [],
            $request->get('page', 1),
            $this->getParameter('posts_number_per_page')
        );

        return $this->render(
            'SonataNewsBundle:Post:index.html.twig',
            [
                'pager' => $pager,
                'blog' => $this->getBlog(),
                'tag' => false,
                'collection' => false,
                'route' => $request->get('_route'),
                'route_parameters' => $request->get('_route_params'),
            ]
        );
    }
}
