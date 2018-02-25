<?php

namespace NCBundle\Entity\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trial
 *
 * @ORM\Table(name="trial")
 * @ORM\Entity(repositoryClass="NCBundle\Repository\Event\TrialRepository")
 */
class Trial
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
     * @var Competition
     *
     * @ORM\ManyToOne(targetEntity="Competition", inversedBy="trials")
     */
    private $competition;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="rules", type="text")
     */
    private $rules;
    /**
     * @var string
     *
     * @ORM\Column(name="raw_rules", type="text")
     */
    protected $rawRules;
    /**
     * @var string
     *
     * @ORM\Column(name="rules_formatter", type="string", length=50)
     */
    protected $rulesFormatter;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TrialResult", mappedBy="trial", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $trialResults;

    public function __construct()
    {
        $this->trialResults = new ArrayCollection();
    }

    public function __toString()
    {
        return '('.$this->getCompetition().') '.$this->getName();
    }

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
     * @return Competition
     */
    public function getCompetition()
    {
        return $this->competition;
    }

    /**
     * @param Competition $competition
     *
     * @return $this
     */
    public function setCompetition($competition)
    {
        $this->competition = $competition;

        return $this;
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

        return $this;
    }

    /**
     * @return string
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param string $rules
     *
     * @return $this
     */
    public function setRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @return string
     */
    public function getRawRules()
    {
        return $this->rawRules;
    }

    /**
     * @param string $rawRules
     *
     * @return $this
     */
    public function setRawRules($rawRules)
    {
        $this->rawRules = $rawRules;

        return $this;
    }

    /**
     * @return string
     */
    public function getRulesFormatter()
    {
        return $this->rulesFormatter;
    }

    /**
     * @param string $rulesFormatter
     *
     * @return $this
     */
    public function setRulesFormatter($rulesFormatter)
    {
        $this->rulesFormatter = $rulesFormatter;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTrialResults()
    {
        return $this->trialResults;
    }

    /**
     * @param ArrayCollection $trialResults
     *
     * @return $this
     */
    public function setTrialResults($trialResults)
    {
        $this->trialResults = $trialResults;

        return $this;
    }

    /**
     * @param TrialResult $trialResult
     *
     * @return $this
     */
    public function addTrialResult(TrialResult $trialResult)
    {
        $trialResult->setTrial($this);

        if (!$this->trialResults->contains($trialResult)) {
            $this->trialResults->add($trialResult);
        }

        return $this;
    }
}
