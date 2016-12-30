<?php

namespace NCBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractContent
 *
 * @package NCBundle\Entity
 *
 * @ORM\Table(name="content")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="content_type", type="string")
 *
 * @UniqueEntity(
 *     fields={"slug"},
 *     message="slug.already_used"
 * )
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
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=50)
     */
    protected $slug;
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
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return AbstractContent
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
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
        if (!$this->tags->contains($tag)) {
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
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
        }

        return $this;
    }

    public function prePersist()
    {
        if (empty($this->getPublicationDateStart())) {
            $this->setPublicationDateStart(new \DateTime());
        }
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    public function preUpdate()
    {
        if (empty($this->getPublicationDateStart())) {
            $this->setPublicationDateStart(new \DateTime());
        }
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * To be published, a content must be enabled and its publication date in the past
     *
     * @return bool
     */
    public function isPublic()
    {
        return $this->getPublicationDateStart()->diff(new \DateTime())->invert == 0 && $this->isEnabled();
    }
}
