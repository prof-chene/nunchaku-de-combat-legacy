<?php

namespace Application\Sonata\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use NCBundle\Entity\AbstractContent;
use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Media
 *
 * @package Application\Sonata\MediaBundle\Entity
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Media extends BaseMedia implements Translatable
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
    protected $description;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="NCBundle\Entity\AbstractContent", mappedBy="image", cascade={"persist"})
     */
    protected $contents;

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
     * @return $this
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
        $content->setImage($this);

        if (!$this->contents->contains($content)) {
            $this->contents->add($content);
        }

        return $this;
    }
}
