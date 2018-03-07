<?php

namespace NCBundle\Controller;

use Application\Sonata\ClassificationBundle\Entity\Collection;
use NCBundle\Entity\Technique\Technique;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TechniqueController
 * @package NCBundle\Controller
 */
class TechniqueController extends Controller
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
                ['context' => 'technique', 'enabled' => true,],
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
        $techniques = $this->get('doctrine.orm.entity_manager')->getRepository(Technique::class)
            ->findByCollectionSlug($slug);

        if (empty($techniques)) {
            throw new NotFoundHttpException('No result found');
        }

        return ['techniques' => $techniques,];
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
        $technique = $this->get('doctrine.orm.entity_manager')->getRepository(Technique::class)
            ->createQueryBuilder('technique')
            ->andWhere('technique.enabled = true')
            ->andWhere('technique.publicationDateStart < CURRENT_TIMESTAMP()')
            ->andWhere('technique.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()->getOneOrNullResult();

        if (empty($technique)) {
            throw new NotFoundHttpException('This technique does not exists');
        }

        return ['technique' => $technique,];
    }
}
