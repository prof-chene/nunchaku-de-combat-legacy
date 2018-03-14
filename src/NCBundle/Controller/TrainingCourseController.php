<?php

namespace NCBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use NCBundle\Entity\Event\TrainingCourse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TrainingCourseController
 * @package NCBundle\Controller
 */
class TrainingCourseController extends Controller
{
    /**
     * @Template
     *
     * @return array
     */
    public function indexAction()
    {
        $futureTrainingCourses = $this->get('doctrine.orm.entity_manager')->getRepository(TrainingCourse::class)
            ->createQueryBuilder('trainingCourse')
            ->andWhere('trainingCourse.enabled = true')
            ->andWhere('trainingCourse.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('trainingCourse.startDate > CURRENT_TIMESTAMP()')
            ->addOrderBy('trainingCourse.startDate')
            ->addOrderBy('trainingCourse.id')
            ->getQuery()->getResult();

        $pastTrainingCourses = $this->get('doctrine.orm.entity_manager')->getRepository(TrainingCourse::class)
            ->createQueryBuilder('trainingCourse')
            ->andWhere('trainingCourse.enabled = true')
            ->andWhere('trainingCourse.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('trainingCourse.startDate <= CURRENT_TIMESTAMP()')
            ->addOrderBy('trainingCourse.startDate', Criteria::DESC)
            ->addOrderBy('trainingCourse.id')
            ->getQuery()->getResult();

        return [
            'futureTrainingCourses' => $futureTrainingCourses,
            'pastTrainingCourses'   => $pastTrainingCourses,
        ];
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
        $trainingCourse = $this->get('doctrine.orm.entity_manager')->getRepository(TrainingCourse::class)
            ->createQueryBuilder('trainingCourse')
            ->andWhere('trainingCourse.enabled = true')
            ->andWhere('trainingCourse.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('trainingCourse.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()->getOneOrNullResult();

        if (empty($trainingCourse)) {
            throw new NotFoundHttpException('This training course does not exists');
        }

        return ['trainingCourse' => $trainingCourse,];
    }
}
