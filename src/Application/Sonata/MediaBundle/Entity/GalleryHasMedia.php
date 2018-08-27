<?php

namespace Application\Sonata\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseGalleryHasMedia as BaseGalleryHasMedia;

/**
 * Class GalleryHasMedia
 *
 * @ORM\Table(name="media_gallery")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class GalleryHasMedia extends BaseGalleryHasMedia
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
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
}
