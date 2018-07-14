<?php

namespace Application\Sonata\ClassificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use Sonata\ClassificationBundle\Entity\BaseCollection as BaseCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Collection
 *
 * @package Application\Sonata\ClassificationBundle\Entity
 *
 * @ORM\Table(name="collection")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Collection extends BaseCollection implements Translatable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * {@inheritdoc}
     *
     * @Gedmo\Translatable
     */
    protected $name;
    /**
     * {@inheritdoc}
     *
     * @Gedmo\Translatable
     */
    protected $slug;

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
}
