<?php

namespace NCBundle\Controller;

use Application\Sonata\ClassificationBundle\Entity\Collection;
use NCBundle\Entity\Technique\Exercise;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ExerciseController
 * @package NCBundle\Controller
 */
class ExerciseController extends Controller
{
    /**
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        $collections = $this->get('doctrine.orm.entity_manager')->getRepository(Collection::class)
            ->findBy(
                ['context' => 'exercise', 'enabled' => true,],
                ['id' => 'ASC']
            );

        return ['collections' => $collections];
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
        $exercises = $this->get('doctrine.orm.entity_manager')->getRepository(Exercise::class)
            ->findByCollectionSlug($slug);

        if (empty($exercises)) {
            throw new NotFoundHttpException('No result found');
        }

        return ['exercises' => $exercises,];
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
        $exercise = $this->get('doctrine.orm.entity_manager')->getRepository(Exercise::class)
            ->findOneBy(['slug' => $slug]);

        return ['exercise' => $exercise,];
    }
}
