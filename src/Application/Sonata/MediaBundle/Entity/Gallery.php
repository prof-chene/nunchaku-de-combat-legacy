<?php

namespace Application\Sonata\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Translatable;
use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Gallery
 *
 * @ORM\Table(name="`gallery`")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Gallery extends BaseGallery implements Translatable
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
     * @var string
     *
     * @Gedmo\Locale
     */
    private $locale;

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
}
