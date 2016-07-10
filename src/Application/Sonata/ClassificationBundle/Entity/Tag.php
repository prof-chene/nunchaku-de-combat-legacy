<?php

namespace Application\Sonata\ClassificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use NCBundle\Entity\AbstractContent;
use Sonata\ClassificationBundle\Entity\BaseTag as BaseTag;

/**
 * Class Tag
 *
 * @package Application\Sonata\ClassificationBundle\Entity
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Tag extends BaseTag
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
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="NCBundle\Entity\AbstractContent", inversedBy="tags")
     * @ORM\JoinTable(name="content_tagged",
     *      joinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="content_id", referencedColumnName="id")}
     *      )
     */
    protected $contents;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
    }

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
     * @return ArrayCollection
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param ArrayCollection $contents
     *
     * @return Tag
     */
    public function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * @param AbstractContent $content
     *
     * @return $this
     */
    public function addContent(AbstractContent $content)
    {
        if(!$this->contents->contains($content)) {
            $this->contents->add($content);
        }

        return $this;
    }
}
