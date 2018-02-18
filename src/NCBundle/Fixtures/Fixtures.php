<?php

namespace NCBundle\Fixtures;

use Application\Sonata\ClassificationBundle\Entity\Context;
use Application\Sonata\ClassificationBundle\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use NCBundle\Entity\Technique\Exercise;
use NCBundle\Entity\Technique\Rank;
use NCBundle\Entity\Technique\RankHolder;
use NCBundle\Entity\Technique\Style;
use NCBundle\Entity\Technique\Technique;
use NCBundle\Entity\Technique\TechniqueExecution;
use Sonata\UserBundle\Entity\UserManager;

class Fixtures extends Fixture
{
    /**
     * @var Context[]
     */
    private $contexts;
    /**
     * @var Tag[]
     */
    private $tags;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');

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
        $superadmin->set(true);
        $superadmin->addRole('ROLE_SUPER_ADMIN');

        $userManager->save($superadmin, false);

        $genders = $superadmin->getGenderList();
        $locales = ['fr', 'en'];
        for ($i = 1; $i <= 50; $i++) {
            $user[$i] = $userManager->create();
            $user[$i]->setUsername('user'.$i);
            $user[$i]->setEmail('user'.$i.'@test.com');
            $user[$i]->setPlainPassword('user'.$i);
            $user[$i]->setEnabled(true);
            $user[$i]->setFirstname('Firstname '.$i);
            $user[$i]->setLastname('Lastname '.$i);
            $user[$i]->setGender($genders[array_rand($genders)]);
            $user[$i]->setLocale($locales[array_rand($locales)]);
            $user[$i]->setDateOfBirth($this->generateDate());

            $userManager->save($user, false);
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

            $entityManager->persist($this->contexts[$contextName]);
        }

        // Tags
        for ($i = 1; $i <= 250; $i++) {
            $this->tags[$i] = new Tag();
            $this->tags[$i]->setName('Tag '.$i);
            $this->tags[$i]->setCreatedAt(new \DateTime());
            $this->tags[$i]->setUpdatedAt(new \DateTime());
            $this->tags[$i]->setEnabled(true);
            $this->tags[$i]->setContext($contexts[array_rand($contexts)]);

            $entityManager->persist($this->tags[$i]);
        }


        // TODO Supplies
        // Supplies

        // Techniques
        for ($i = 1; $i <= 500; $i++) {
            $technique = new Technique();
            $technique->setTitle('Technique '.$i);
            $technique->setPublicationDateStart(new \DateTime());
            $technique->setCreatedAt(new \DateTime());
            $technique->setUpdatedAt(new \DateTime());
            $technique->setEnabled(true);
            $content = $this->generateText();
            $technique->setContentFormatter('richhtml');
            $technique->setRawContent($content);
            $technique->setContent($content);
            $this->addRandomTags($technique);

            // Exercises
            for ($j = 1; $j <= mt_rand(0, 4); $j++) {
                $exercise = new Exercise();
                $exercise->setTitle('Exercise '.$i.'-'.$j);
                $exercise->setPublicationDateStart(new \DateTime());
                $exercise->setCreatedAt(new \DateTime());
                $exercise->setUpdatedAt(new \DateTime());
                $exercise->setEnabled(true);
                $content = $this->generateText();
                $exercise->setContentFormatter('richhtml');
                $exercise->setRawContent($content);
                $exercise->setContent($content);
                $this->addRandomTags($exercise);
                
                // TODO Supplies

                $techniqueExecution = new TechniqueExecution();
                $techniqueExecution->setDetail($this->generateText());

                $technique->addTechniqueExecution($techniqueExecution);
                $exercise->addTechniqueExecution($techniqueExecution);
            }
        }

        // Styles
        for ($i = 1; $i <= 15; $i++) {
            $style = new Style();
            $style->setTitle('Style '.$i);
            $style->setPublicationDateStart(new \DateTime());
            $style->setCreatedAt(new \DateTime());
            $style->setUpdatedAt(new \DateTime());
            $style->setEnabled(true);
            $content = $this->generateText();
            $style->setContentFormatter('richhtml');
            $style->setRawContent($content);
            $style->setContent($content);
            $this->addRandomTags($style);

            // Ranks
            for ($j = 1; $j <= mt_rand(1, 20); $j++) {
                $rank = new Rank();
                $rank->setTitle('Rank '.$i.'-'.$j);
                $rank->setPublicationDateStart(new \DateTime());
                $rank->setCreatedAt(new \DateTime());
                $rank->setUpdatedAt(new \DateTime());
                $rank->setEnabled(true);
                $content = $this->generateText();
                $rank->setContentFormatter('richhtml');
                $rank->setRawContent($content);
                $rank->setContent($content);
                $this->addRandomTags($rank);

                $rank->setLevel($j);
                $style->addRank($rank);

                // RankHolders
                for ($k = 1; $k <= mt_rand(1, 10); $k++) {
                    $rankHolder = new RankHolder();
                    $rankHolder->setHolder($user[array_rand($user)]);
                    $rankHolder->setPromotedAt($this->generateDate());
                    $rankHolder->setJury('Jury '.$i.'-'.$j.'-'.$k);
                    $rank->addHolder($rankHolder);
                }

                // TODO TechniqueExecutions
            }

            $entityManager->persist($style);
        }

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

        return new \DateTime($timeStamp);
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
