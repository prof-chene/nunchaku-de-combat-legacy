<?php

namespace Application\Sonata\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractContent;
use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;

/**
 * Class Media
 *
 * @package Application\Sonata\MediaBundle\Entity
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Media extends BaseMedia
{
    /**
     * @var int $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var AbstractContent
     *
     * @ORM\ManyToOne(targetEntity="NCBundle\Entity\AbstractContent", inversedBy="medias")
     */
    protected $content;

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
     * @return AbstractContent
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param AbstractContent $content
     *
     * @return Media
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}
