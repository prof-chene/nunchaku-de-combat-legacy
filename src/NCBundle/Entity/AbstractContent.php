<?php

namespace NCBundle\Entity;

use Application\Sonata\ClassificationBundle\Entity\Tag;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class AbstractContent
 *
 * @package NCBundle\Entity
 *
 * @ORM\Table(name="content")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", inversedBy="contents", cascade={"persist"})
     */
    protected $thumbnail;
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Application\Sonata\ClassificationBundle\Entity\Tag", inversedBy="contents")
     * @ORM\JoinTable(name="content_tagged",
     *      joinColumns={@ORM\JoinColumn(name="content_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     */
    protected $tags;

    public function __construct()
    {
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
        $this->slug = self::slugify($slug);

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
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param ArrayCollection $thumbnail
     *
     * @return $this
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

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
     * source : http://snipplr.com/view/22741/slugify-a-string-in-php/.
     *
     * @static
     *
     * @param string $text
     *
     * @return mixed|string
     */
    public static function slugify($text)
    {
        $text = Slugify::create()->slugify($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if (empty($this->getPublicationDateStart())) {
            $this->setPublicationDateStart(new \DateTime());
        }
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
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
