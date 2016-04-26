<?php

namespace NCFrontBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rank
 *
 * @ORM\Table(name="rank")
 * @ORM\Entity(repositoryClass="NCFrontBundle\Repository\RankRepository")
 */
class Rank
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;
    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer", length=5)
     */
    private $level;
    /**
     * @var Style
     *
     * @ORM\ManyToOne(targetEntity="Style", inversedBy="ranks")
     */
    private $style;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Syllabus", mappedBy="rank")
     */
    private $syllabuses;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Application\Sonata\UserBundle\Entity\User", mappedBy="rank")
     */
    private $users;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Rank
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Rank
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     *
     * @return Rank
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Style
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param Style $style
     *
     * @return Rank
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSyllabuses()
    {
        return $this->syllabuses;
    }

    /**
     * @param ArrayCollection $syllabuses
     *
     * @return Rank
     */
    public function setSyllabuses($syllabuses)
    {
        $this->syllabuses = $syllabuses;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection $users
     *
     * @return Rank
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }
}
