<?php

namespace NCBundle\Controller;

use Application\Sonata\ClassificationBundle\Entity\Collection;
use Doctrine\ORM\Query\Expr\Join;
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
     * @param string $slug
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
     * @param string $slug
     *
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function viewAction($slug)
    {
        $exercise = $this->get('doctrine.orm.entity_manager')->getRepository(Exercise::class)
            ->createQueryBuilder('exercise')
            ->leftJoin(
                'exercise.supplies',
                'supplies',
                Join::WITH,
                'supplies.enabled = true and supplies.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('exercise.enabled = true')
            ->andWhere('exercise.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('exercise.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()->getOneOrNullResult();

        if (empty($exercise)) {
            throw new NotFoundHttpException('This exercise does not exists');
        }

        return ['exercise' => $exercise,];
    }
}
