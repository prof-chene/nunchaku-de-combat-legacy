<?php

namespace Application\Sonata\MediaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use NCBundle\Entity\AbstractContent;
use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Media
 *
 * @ORM\Table(name="`media`")
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
    private $id;
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
     * @var string
     *
     * @Gedmo\Locale
     */
    private $locale;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="NCBundle\Entity\AbstractContent", mappedBy="image", cascade={"persist"})
     */
    private $contents;

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
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
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
