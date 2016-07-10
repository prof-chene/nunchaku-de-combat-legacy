<?php

namespace Application\Sonata\ClassificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseCategory as BaseCategory;

/**
 * Class Category
 *
 * @package Application\Sonata\ClassificationBundle\Entity
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Category extends BaseCategory
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
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
}
