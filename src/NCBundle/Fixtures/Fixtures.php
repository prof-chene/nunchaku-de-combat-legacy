<?php

namespace NCBundle\Fixtures;

use Application\Sonata\ClassificationBundle\Entity\Context;
use Application\Sonata\ClassificationBundle\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use NCBundle\Entity\FAQ\FAQ;
use NCBundle\Entity\FAQ\Question;
use NCBundle\Entity\Technique\Exercise;
use NCBundle\Entity\Technique\Rank;
use NCBundle\Entity\Technique\RankHolder;
use NCBundle\Entity\Technique\RankRequirement;
use NCBundle\Entity\Technique\Style;
use NCBundle\Entity\Technique\Supply;
use NCBundle\Entity\Technique\Technique;
use NCBundle\Entity\Technique\TechniqueExecution;
use Sonata\UserBundle\Entity\UserManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Fixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var
     */
    private $container;
    /**
     * @var Context[]
     */
    private $contexts;
    /**
     * @var Tag[]
     */
    private $tags;

    /**
     * @inheritdoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Users
        /**
         * @var UserManager
         */
        $userManager = $this->container->get('sonata.user.orm.user_manager');
        $superadmin = $userManager->create();
        $superadmin->setUsername('superadmin');
        $superadmin->setEmail('superadmin@test.com');
        $superadmin->setPlainPassword('superadmin');
        $superadmin->setEnabled(true);
        $superadmin->addRole('ROLE_SUPER_ADMIN');

        $userManager->save($superadmin, false);

        $genders = $superadmin->getGenderList();
        $locales = ['fr', 'en'];
        for ($i = 1; $i <= 50; $i++) {
            $users[$i] = $userManager->create();
            $users[$i]->setUsername('user'.$i);
            $users[$i]->setEmail('user'.$i.'@test.com');
            $users[$i]->setPlainPassword('user'.$i);
            $users[$i]->setEnabled(true);
            $users[$i]->setFirstname('Firstname '.$i);
            $users[$i]->setLastname('Lastname '.$i);
            $users[$i]->setGender($genders[array_rand($genders)]);
            $users[$i]->setLocale($locales[array_rand($locales)]);
            $users[$i]->setDateOfBirth($this->generateDate());

            $userManager->save($users[$i], false);
        }

        // Contexts
        $contexts = ['content', 'event', 'news', 'technique'];
        foreach ($contexts as $contextName) {
            $this->contexts[$contextName] = new Context();
            $this->contexts[$contextName]->setId(strtolower($contextName));
            $this->contexts[$contextName]->setName(ucfirst($contextName));
            $this->contexts[$contextName]->setEnabled(true);
            $this->contexts[$contextName]->setCreatedAt(new \DateTime());
            $this->contexts[$contextName]->setUpdatedAt(new \DateTime());

            $manager->persist($this->contexts[$contextName]);
        }

        // Tags
        for ($i = 1; $i <= 250; $i++) {
            $this->tags[$i] = new Tag();
            $this->tags[$i]->setName('Tag '.$i);
            $this->tags[$i]->setCreatedAt(new \DateTime());
            $this->tags[$i]->setUpdatedAt(new \DateTime());
            $this->tags[$i]->setEnabled(true);
            $this->tags[$i]->setContext($this->contexts[array_rand($this->contexts)]);

            $manager->persist($this->tags[$i]);
        }

        // Supplies
        for ($i = 1; $i <= 500; $i++) {
            $supplies[$i] = new Supply();
            $supplies[$i]->setTitle('Supply '.$i);
            $supplies[$i]->setPublicationDateStart(new \DateTime());
            $supplies[$i]->setCreatedAt(new \DateTime());
            $supplies[$i]->setUpdatedAt(new \DateTime());
            $supplies[$i]->setEnabled(true);
            $content = $this->generateText();
            $supplies[$i]->setContentFormatter('richhtml');
            $supplies[$i]->setRawContent($content);
            $supplies[$i]->setContent($content);
            $this->addRandomTags($supplies[$i]);

            $manager->persist($supplies[$i]);
        }

        // Techniques
        for ($i = 1; $i <= 500; $i++) {
            $techniques[$i] = new Technique();
            $techniques[$i]->setTitle('Technique '.$i);
            $techniques[$i]->setPublicationDateStart(new \DateTime());
            $techniques[$i]->setCreatedAt(new \DateTime());
            $techniques[$i]->setUpdatedAt(new \DateTime());
            $techniques[$i]->setEnabled(true);
            $content = $this->generateText();
            $techniques[$i]->setContentFormatter('richhtml');
            $techniques[$i]->setRawContent($content);
            $techniques[$i]->setContent($content);
            $this->addRandomTags($techniques[$i]);

            // Exercises
            for ($j = 1; $j <= mt_rand(0, 4); $j++) {
                $exercises[$i.'-'.$j] = new Exercise();
                $exercises[$i.'-'.$j]->setTitle('Exercise '.$i.'-'.$j);
                $exercises[$i.'-'.$j]->setPublicationDateStart(new \DateTime());
                $exercises[$i.'-'.$j]->setCreatedAt(new \DateTime());
                $exercises[$i.'-'.$j]->setUpdatedAt(new \DateTime());
                $exercises[$i.'-'.$j]->setEnabled(true);
                $content = $this->generateText();
                $exercises[$i.'-'.$j]->setContentFormatter('richhtml');
                $exercises[$i.'-'.$j]->setRawContent($content);
                $exercises[$i.'-'.$j]->setContent($content);
                $this->addRandomTags($exercises[$i.'-'.$j]);

                for ($k = 1; $k <= mt_rand(0, 2); $k++) {
                    $exercises[$i.'-'.$j]->addSupply($supplies[array_rand($supplies)]);
                }

                // TechniqueExecutions
                $techniqueExecutions[$i.'-'.$j.'-'.$k] = new TechniqueExecution();
                $techniqueExecutions[$i.'-'.$j.'-'.$k]->setDetail($this->generateText());

                $techniques[$i]->addTechniqueExecution($techniqueExecutions[$i.'-'.$j.'-'.$k]);
                $exercises[$i.'-'.$j]->addTechniqueExecution($techniqueExecutions[$i.'-'.$j.'-'.$k]);
            }
        }

        // Styles
        for ($i = 1; $i <= 15; $i++) {
            $styles[$i] = new Style();
            $styles[$i]->setTitle('Style '.$i);
            $styles[$i]->setPublicationDateStart(new \DateTime());
            $styles[$i]->setCreatedAt(new \DateTime());
            $styles[$i]->setUpdatedAt(new \DateTime());
            $styles[$i]->setEnabled(true);
            $content = $this->generateText();
            $styles[$i]->setContentFormatter('richhtml');
            $styles[$i]->setRawContent($content);
            $styles[$i]->setContent($content);
            $this->addRandomTags($styles[$i]);

            // Ranks
            for ($j = 1; $j <= mt_rand(1, 20); $j++) {
                $ranks[$i.'-'.$j] = new Rank();
                $ranks[$i.'-'.$j]->setTitle('Rank '.$i.'-'.$j);
                $ranks[$i.'-'.$j]->setPublicationDateStart(new \DateTime());
                $ranks[$i.'-'.$j]->setCreatedAt(new \DateTime());
                $ranks[$i.'-'.$j]->setUpdatedAt(new \DateTime());
                $ranks[$i.'-'.$j]->setEnabled(true);
                $content = $this->generateText();
                $ranks[$i.'-'.$j]->setContentFormatter('richhtml');
                $ranks[$i.'-'.$j]->setRawContent($content);
                $ranks[$i.'-'.$j]->setContent($content);
                $this->addRandomTags($ranks[$i.'-'.$j]);

                $ranks[$i.'-'.$j]->setLevel($j);
                $styles[$i]->addRank($ranks[$i.'-'.$j]);

                // RankHolders
                for ($k = 1; $k <= mt_rand(1, 10); $k++) {
                    $rankHolders[$i.'-'.$j.'-'.$k] = new RankHolder();
                    $rankHolders[$i.'-'.$j.'-'.$k]->setHolder($users[array_rand($users)]);
                    $rankHolders[$i.'-'.$j.'-'.$k]->setPromotedAt($this->generateDate());
                    $rankHolders[$i.'-'.$j.'-'.$k]->setJury('Jury '.$i.'-'.$j.'-'.$k);
                    $ranks[$i.'-'.$j]->addHolder($rankHolders[$i.'-'.$j.'-'.$k]);
                }

                $manager->persist($ranks[$i.'-'.$j]);

                // RankRequirements
                for ($k = 1; $k <= mt_rand(2, 10); $k++) {
                    $rankRequirements[$i.'-'.$j.'-'.$k] = new RankRequirement();
                    $rankRequirements[$i.'-'.$j.'-'.$k]->setExercise($exercises[array_rand($exercises)]);
                    $rankRequirements[$i.'-'.$j.'-'.$k]->setPoints(mt_rand(5,30));
                    $rankRequirements[$i.'-'.$j.'-'.$k]->setDetail('Detail '.$i.'-'.$j.'-'.$k);

                    $ranks[$i.'-'.$j]->addRankRequirement($rankRequirements[$i.'-'.$j.'-'.$k]);
                }
            }

            $manager->persist($styles[$i]);
        }

        // FAQs
        for ($i = 1; $i <= 10; $i++) {
            $faqs[$i] = new FAQ();
            $faqs[$i]->setTitle('Style '.$i);
            $faqs[$i]->setPublicationDateStart(new \DateTime());
            $faqs[$i]->setCreatedAt(new \DateTime());
            $faqs[$i]->setUpdatedAt(new \DateTime());
            $faqs[$i]->setEnabled(true);
            $content = $this->generateText();
            $faqs[$i]->setContentFormatter('richhtml');
            $faqs[$i]->setRawContent($content);
            $faqs[$i]->setContent($content);
            $this->addRandomTags($faqs[$i]);

            // Questions
            for ($j = 1; $j <= mt_rand(2, 15); $j++) {
                $questions[$i.'-'.$j] = new Question();
                $questions[$i.'-'.$j]->setQuestion('Question '.$i.'-'.$j);
                $questions[$i.'-'.$j]->setAnswer('Answer '.$i.'-'.$j);
                $questions[$i.'-'.$j]->setPosition($j);

                $faqs[$i]->addQuestion($questions[$i.'-'.$j]);
            }

            $manager->persist($faqs[$i]);
        }

        $manager->flush();
    }

    /**
     * @param int    $minParagraphs
     * @param int    $maxParagraphs
     * @param string $length
     * @param bool   $decorate
     * @param bool   $link
     * @param bool   $ul
     * @param bool   $ol
     * @param bool   $caps
     *
     * @return bool|string
     */
    private function generateText(
        $minParagraphs = 1,
        $maxParagraphs = 10,
        $length = 'random',
        $decorate = true,
        $link = true,
        $ul = true,
        $ol = true,
        $caps = false
    ) {
        $paragraphs = mt_rand(intval($minParagraphs), intval($maxParagraphs));

        $lengths = ['short', 'medium', 'long', 'verylong'];
        if ($length === 'random') {
            $length = $lengths[array_rand($lengths)];
        } else if (!in_array($length, $lengths)) {
            $length = null;
        }

        $url = 'https://loripsum.net/api/'.$paragraphs;
        if ($length) {
            $url .= '/'.$length;
        }
        if ($decorate) {
            $url .= '/decorate';
        }
        if ($link) {
            $url .= '/link';
        }
        if ($ul) {
            $url .= '/ul';
        }
        if ($ol) {
            $url .= '/ol';
        }
        if ($caps) {
            $url .= '/allcaps';
        }

        return file_get_contents($url);
    }

    /**
     * @param int  $minTimeStamp
     * @param null|int $maxTimeStamp
     *
     * @return \DateTime
     */
    private function generateDate($minTimeStamp = 1, $maxTimeStamp = null)
    {
        $timeStamp = mt_rand(intval($minTimeStamp), (!is_null($maxTimeStamp) ? intval($maxTimeStamp) : time()));
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($timeStamp);

        return $dateTime;
    }

    /**
     * @param mixed $object
     * @param Tag[] $tags
     * @param int   $numberOfTags
     * @param bool  $randomNumberOfTags
     */
    private function addRandomTags($object, $tags = [], $numberOfTags = 5, $randomNumberOfTags = true)
    {
        if (empty($tags)) {
            $tags = $this->tags;
        }
        if (method_exists($object, 'addTag') && !empty($tags) && is_array($tags)) {
            if ($randomNumberOfTags) {
                $numberOfTags = mt_rand(1, $numberOfTags);
            }
            for ($i = 1; $i <= $numberOfTags; $i++) {
                $object->addTag($tags[array_rand($tags)]);
            }
        }
    }
}
