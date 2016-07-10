<?php

namespace NCBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractContent
 *
 * @package NCBundle\Entity
 *
 * @ORM\Table(name="content")
 * @ORM\Entity
 */
abstract class AbstractContent
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
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;
    /**
     * @var
     *
     * @ORM\Column(name="publication_date_start", type="datetime")
     */
    protected $publicationDateStart;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Sonata\ClassificationBundle\Entity\Tag", mappedBy="contents")
     */
    protected $tags;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Sonata\MediaBundle\Entity\Media", mappedBy="content")
     */
    protected $medias;

    public function __construct()
    {
        $this->medias = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     *
     * @return AbstractContent
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return AbstractContent
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return AbstractContent
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublicationDateStart()
    {
        return $this->publicationDateStart;
    }

    /**
     * @param mixed $publicationDateStart
     *
     * @return AbstractContent
     */
    public function setPublicationDateStart($publicationDateStart)
    {
        $this->publicationDateStart = $publicationDateStart;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     *
     * @return AbstractContent
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param Tag $tag
     *
     * @return $this
     */
    public function addTag(Tag $tag)
    {
        if(!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * @param ArrayCollection $medias
     *
     * @return AbstractContent
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;

        return $this;
    }
    /**
     * @param Media $media
     *
     * @return $this
     */
    public function addMedia(Media $media)
    {
        if(!$this->medias->contains($media)) {
            $this->medias->add($media);
        }

        return $this;
    }
}
