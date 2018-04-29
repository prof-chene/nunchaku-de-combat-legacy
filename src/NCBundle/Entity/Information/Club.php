<?php

namespace NCBundle\Entity\Information;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use NCBundle\Entity\AbstractContent;

/**
 * Class Club
 *
 * @ORM\Table(name="club")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Information\ClubRepository")
 */
class Club extends AbstractContent
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=100, nullable=true)
     */
    private $phone;
    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=11, scale=8, nullable=true)
     */
    private $latitude;
    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=11, scale=8, nullable=true)
     */
    private $longitude;
    /**
     * @var string
     *
     * @ORM\Column(name="website_url", type="string", length=100, nullable=true)
     */
    private $websiteUrl;
    /**
     * @var
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="Trainer", mappedBy="club")
     */
    private $trainers;
    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="SocialMediaAccount", mappedBy="club")
     */
    private $socialMediaAccounts;
    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="ScheduledLesson", mappedBy="club")
     */
    private $scheduledLessons;
    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     *
     * @ORM\ManyToMany(targetEntity="NCBundle\Entity\Technique\Style", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $styles;

    /**
     * Club constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->trainers = new ArrayCollection();
        $this->socialMediaAccounts = new ArrayCollection();
        $this->scheduledLessons = new ArrayCollection();
        $this->styles = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     *
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     *
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return string
     */
    public function getWebsiteUrl(): string
    {
        return $this->websiteUrl;
    }

    /**
     * @param string $websiteUrl
     *
     * @return $this
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTrainers()
    {
        return $this->trainers;
    }

    /**
     * @param ArrayCollection $trainers
     *
     * @return $this
     */
    public function setTrainers($trainers)
    {
        $this->trainers = $trainers;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSocialMediaAccounts(): ArrayCollection
    {
        return $this->socialMediaAccounts;
    }

    /**
     * @param ArrayCollection $socialMediaAccounts
     *
     * @return $this
     */
    public function setSocialMediaAccounts($socialMediaAccounts)
    {
        $this->socialMediaAccounts = $socialMediaAccounts;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getScheduledLessons(): ArrayCollection
    {
        return $this->scheduledLessons;
    }

    /**
     * @param ArrayCollection $scheduledLessons
     *
     * @return $this
     */
    public function setScheduledLessons($scheduledLessons)
    {
        $this->scheduledLessons = $scheduledLessons;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getStyles(): ArrayCollection
    {
        return $this->styles;
    }

    /**
     * @param ArrayCollection $styles
     *
     * @return $this
     */
    public function setStyles($styles)
    {
        $this->styles = $styles;

        return $this;
    }
}
