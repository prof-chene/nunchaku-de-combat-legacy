<?php

namespace NCBundle\Entity\Information;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Model\User;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Translatable\Translatable;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Trainer
 *
 * @ORM\Table(name="`trainer`")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Information\TrainerRepository")
 */
class Trainer implements Translatable
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
     * @Assert\Length(max=100)
     *
     * @ORM\Column(name="firstname", type="string", length=100)
     */
    private $firstname;
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     *
     * @ORM\Column(name="lastname", type="string", length=100)
     */
    private $lastname;
    /**
     * @var string
     *
     * @Gedmo\Translatable
     *
     * @ORM\Column(name="cv", type="text", nullable=true)
     */
    private $cv;
    /**
     * @var string
     *
     * @Gedmo\Locale
     */
    private $locale;
    /**
     * @var User
     *
     * @Assert\Valid()
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     */
    private $user;
    /**
     * @var Club
     *
     * @Assert\Valid()
     *
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="trainers")
     * @ORM\JoinColumn(nullable=false)
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
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return $this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return $this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * @param string $cv
     *
     * @return $this
     */
    public function setCv($cv)
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

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
