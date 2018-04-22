<?php

namespace NCBundle\Entity\Information;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NCBundle\Entity\AbstractContent;

/**
 * FAQ
 *
 * @ORM\Table(name="club")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Information\ClubRepository")
 */
class Club extends AbstractContent
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    private $latitude;

    private $longitude;

    private $websiteUrl;


    private $trainers;

    private $socialMediaAccounts;

    private $scheduledLessons;

    public function __construct()
    {
        parent::__construct();

    }
}
