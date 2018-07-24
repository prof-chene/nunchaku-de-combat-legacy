<?php

namespace NCBundle\Entity\Information;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @Assert\Length(max=100)
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;
    /**
     * @var string
     *
     * @Assert\Length(max=100)
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
     * @Assert\Length(max=100)
     *
     * @ORM\Column(name="website_url", type="string", length=100, nullable=true)
     */
    private $websiteUrl;
    /**
     * @var
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="Trainer", mappedBy="club", cascade={"persist", "remove"})
     */
    private $trainers;
    /**
     * @var Collection
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="SocialMediaAccount", mappedBy="club", cascade={"persist", "remove"})
     * @ORM\OrderBy({"socialMedia" = "ASC"})
     */
    private $socialMediaAccounts;
    /**
     * @var Collection
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="ScheduledLesson", mappedBy="club", cascade={"persist", "remove"})
     * @ORM\OrderBy({"dayOfTheWeek" = "ASC", "startTime" = "ASC"})
     */
    private $scheduledLessons;
    /**
     * @var Collection
     *
     * @Assert\Valid()
     *
     * @ORM\ManyToMany(targetEntity="NCBundle\Entity\Technique\Style", orphanRemoval=true)
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
    public function getName()
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
        $this->setSlug($name);

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
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
    public function getPhone()
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
    public function getLatitude()
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
    public function getLongitude()
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
    public function getWebsiteUrl()
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
     * @param Collection $trainers
     *
     * @return $this
     */
    public function setTrainers($trainers)
    {
        $this->trainers = $trainers;

        return $this;
    }

    /**
     * @param Trainer $trainer
     *
     * @return $this
     */
    public function addTrainer(Trainer $trainer)
    {
        $trainer->setClub($this);

        if (!$this->trainers->contains($trainer)) {
            $this->trainers->add($trainer);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSocialMediaAccounts()
    {
        return $this->socialMediaAccounts;
    }

    /**
     * @param Collection $socialMediaAccounts
     *
     * @return $this
     */
    public function setSocialMediaAccounts($socialMediaAccounts)
    {
        $this->socialMediaAccounts = $socialMediaAccounts;

        return $this;
    }

    /**
     * @param SocialMediaAccount $socialMediaAccount
     *
     * @return $this
     */
    public function addSocialMediaAccount(SocialMediaAccount $socialMediaAccount)
    {
        $socialMediaAccount->setClub($this);

        if (!$this->socialMediaAccounts->contains($socialMediaAccount)) {
            $this->socialMediaAccounts->add($socialMediaAccount);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getScheduledLessons()
    {
        return $this->scheduledLessons;
    }

    /**
     * @param Collection $scheduledLessons
     *
     * @return $this
     */
    public function setScheduledLessons($scheduledLessons)
    {
        $this->scheduledLessons = $scheduledLessons;

        return $this;
    }

    /**
     * @param ScheduledLesson $scheduledLesson
     *
     * @return $this
     */
    public function addScheduledLesson(ScheduledLesson $scheduledLesson)
    {
        $scheduledLesson->setClub($this);

        if (!$this->scheduledLessons->contains($scheduledLesson)) {
            $this->scheduledLessons->add($scheduledLesson);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * @param Collection $styles
     *
     * @return $this
     */
    public function setStyles($styles)
    {
        $this->styles = $styles;

        return $this;
    }
}
