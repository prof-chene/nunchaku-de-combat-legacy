<?php

namespace Application\Sonata\ClassificationBundle\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseContext as BaseContext;

/**
 * Class Context
 *
 * @ORM\Table(name="`context`")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Context extends BaseContext
{
    const EXERCISE_CONTEXT = 'exercise';
    const TECHNIQUE_CONTEXT = 'technique';
    const SUPPLY_CONTEXT = 'supply';
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
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

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = Slugify::create()->slugify($id);
    }
}
