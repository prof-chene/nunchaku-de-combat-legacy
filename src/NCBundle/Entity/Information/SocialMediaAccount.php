<?php

namespace NCBundle\Entity\Information;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SocialMediaAccount
 *
 * @ORM\Table(name="social_media_account")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Information\SocialMediaAccountRepository")
 */
class SocialMediaAccount
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Choice({"facebook", "google", "instagram", "pinterest", "reddit", "soundcloud", "tumblr", "twitter"})
     *
     * @ORM\Column(name="social_media", type="string", length=10)
     */
    private $socialMedia;
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
    /**
     * @var Club
     *
     * @Assert\Valid()
     *
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="socialMediaAccounts")
     */
    private $club;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSocialMedia()
    {
        return $this->socialMedia;
    }

    /**
     * @param string $socialMedia
     *
     * @return $this
     */
    public function setSocialMedia($socialMedia)
    {
        $this->socialMedia = $socialMedia;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Club
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * @param Club $club
     *
     * @return $this
     */
    public function setClub($club)
    {
        $this->club = $club;

        return $this;
    }
}
