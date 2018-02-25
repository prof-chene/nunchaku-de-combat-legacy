<?php

namespace NCBundle\Fixtures;

use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\ClassificationBundle\Entity\Context;
use Application\Sonata\ClassificationBundle\Entity\Tag;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use NCBundle\Entity\Event\Competition;
use NCBundle\Entity\Event\Participant;
use NCBundle\Entity\Event\Show;
use NCBundle\Entity\Event\TrainingCourse;
use NCBundle\Entity\Event\Trial;
use NCBundle\Entity\Event\TrialResult;
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
use Sonata\MediaBundle\Entity\MediaManager;
use Sonata\UserBundle\Entity\UserManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\File;

class Fixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var string
     */
    private $uploadPath;
    /**
     * @var array
     */
    private $randomTexts;
    /**
     * @var array
     */
    private $genders;
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
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $this->uploadPath = $this->container->get('kernel')->getRootDir() . '/../web/uploads/fixtures';
        if (!is_readable($this->uploadPath)) {
            mkdir($this->uploadPath);
        }
        // Random texts
        for ($i = 1; $i <= 50; $i++) {
            $this->randomTexts[] = $this->generateText();
        }
        /**
         * @var UserManager
         */
        $userManager = $this->container->get('sonata.user.orm.user_manager');
        /**
         * @var MediaManager
         */
        $mediaManager = $this->container->get('sonata.media.manager.media');

        // Superadmin
        $superadmin = $userManager->create();
        $superadmin->setUsername('superadmin');
        $superadmin->setEmail('superadmin@test.com');
        $superadmin->setPlainPassword('superadmin');
        $superadmin->setEnabled(true);
        $superadmin->addRole('ROLE_SUPER_ADMIN');
        $userManager->save($superadmin, false);

        // Genders
        $this->genders = $superadmin->getGenderList();

        // Contexts
        $contextNames = ['content', 'event', 'news', 'technique'];
        foreach ($contextNames as $contextName) {
            $contexts[$contextName] = new Context();
            $contexts[$contextName]->setId(strtolower($contextName));
            $contexts[$contextName]->setName(ucfirst($contextName));
            $contexts[$contextName]->setEnabled(true);
            $contexts[$contextName]->setCreatedAt(new \DateTime());
            $contexts[$contextName]->setUpdatedAt(new \DateTime());

            // Categories
            $categories[$contextName] = new Category();
            $categories[$contextName]->setContext($contexts[$contextName]);
            $categories[$contextName]->setName(ucfirst($contextName));
            $categories[$contextName]->setEnabled(true);
            $categories[$contextName]->setPosition(0);

            $manager->persist($contexts[$contextName]);
            $manager->persist($categories[$contextName]);
        }

        // Tags
        for ($i = 1; $i <= 20; $i++) {
            $tags[$i] = new Tag();
            $tags[$i]->setName('Tag '.$i);
            $tags[$i]->setCreatedAt(new \DateTime());
            $tags[$i]->setUpdatedAt(new \DateTime());
            $tags[$i]->setEnabled(true);
            $tags[$i]->setContext($contexts[array_rand($contexts)]);

            $manager->persist($tags[$i]);
        }

        // We will flush and clear regularly to avoid memory leak
        $manager->flush();

        unset($contexts);
        unset($tags);

        for ($loop = 0; $loop <= 19; $loop++) {
            printf('===============================');
            printf('Loop '.($loop+1));
            // Tags and contexts are flushed from entityManager, we have to fetch them every time
            $this->contexts = $manager->getRepository(Context::class)->findAll();
            $this->tags = $manager->getRepository(Tag::class)->findAll();

            // Users
            $locales = ['fr', 'en'];
            for ($i = ($loop * 20) + 1; $i <= ($loop * 20) + 20; $i++) {
                $users[$i] = $userManager->create();
                $users[$i]->setUsername('user'.$i);
                $users[$i]->setEmail('user'.$i.'@test.com');
                $users[$i]->setPlainPassword('user'.$i);
                $users[$i]->setEnabled(true);
                $users[$i]->setFirstname('Firstname '.$i);
                $users[$i]->setLastname('Lastname '.$i);
                $users[$i]->setGender($this->genders[array_rand($this->genders)]);
                $users[$i]->setLocale($locales[array_rand($locales)]);
                $users[$i]->setDateOfBirth($this->generateDate());
                $users[$i]->setPhone($this->generatePhoneNumber());

                $userManager->save($users[$i], false);
            }

            // Supplies
            for ($i = ($loop * 2) + 1; $i <= ($loop * 2) + 2; $i++) {
                $supplies[$i] = new Supply();
                $supplies[$i]->setTitle('Supply '.$i);
                $supplies[$i]->setPublicationDateStart(new \DateTime());
                $supplies[$i]->setCreatedAt(new \DateTime());
                $supplies[$i]->setUpdatedAt(new \DateTime());
                $supplies[$i]->setEnabled(true);
                $content = $this->randomTexts[array_rand($this->randomTexts)];;
                $supplies[$i]->setContentFormatter('richhtml');
                $supplies[$i]->setRawContent($content);
                $supplies[$i]->setContent($content);
                $this->addRandomTags($supplies[$i]);

                $manager->persist($supplies[$i]);
            }

            // Techniques
            for ($i = ($loop * 10) + 1; $i <= ($loop * 10) + 10; $i++) {
                $techniques[$i] = new Technique();
                $techniques[$i]->setTitle('Technique '.$i);
                $techniques[$i]->setPublicationDateStart(new \DateTime());
                $techniques[$i]->setCreatedAt(new \DateTime());
                $techniques[$i]->setUpdatedAt(new \DateTime());
                $techniques[$i]->setEnabled(true);
                $content = $this->randomTexts[array_rand($this->randomTexts)];;
                $techniques[$i]->setContentFormatter('richhtml');
                $techniques[$i]->setRawContent($content);
                $techniques[$i]->setContent($content);
                $this->addRandomTags($techniques[$i]);

                // Exercises
                for ($j = 1; $j <= mt_rand(1, 4); $j++) {
                    $exercises[$i.'-'.$j] = new Exercise();
                    $exercises[$i.'-'.$j]->setTitle('Exercise '.$i.'-'.$j);
                    $exercises[$i.'-'.$j]->setPublicationDateStart(new \DateTime());
                    $exercises[$i.'-'.$j]->setCreatedAt(new \DateTime());
                    $exercises[$i.'-'.$j]->setUpdatedAt(new \DateTime());
                    $exercises[$i.'-'.$j]->setEnabled(true);
                    $content = $this->randomTexts[array_rand($this->randomTexts)];;
                    $exercises[$i.'-'.$j]->setContentFormatter('richhtml');
                    $exercises[$i.'-'.$j]->setRawContent($content);
                    $exercises[$i.'-'.$j]->setContent($content);
                    $this->addRandomTags($exercises[$i.'-'.$j]);

                    for ($k = 1; $k <= mt_rand(0, 2); $k++) {
                        $exercises[$i.'-'.$j]->addSupply($supplies[array_rand($supplies)]);
                    }

                    $manager->persist($exercises[$i.'-'.$j]);
                }

                $manager->persist($techniques[$i]);
            }

            $manager->flush();

            // TechniqueExecutions
            foreach ($exercises as $key => $exercise) {
                $techniqueExecutions[$key] = new TechniqueExecution();
                $techniqueExecutions[$key]->setDetail('Detail '.$key);

                $techniques[explode('-', $key)[0]]->addTechniqueExecution($techniqueExecutions[$key]);
                $exercise->addTechniqueExecution($techniqueExecutions[$key]);
            }

            // Styles
            for ($i = $loop + 1; $i <= $loop + 1; $i++) {
                $styles[$i] = new Style();
                $styles[$i]->setTitle('Style '.$i);
                $styles[$i]->setPublicationDateStart(new \DateTime());
                $styles[$i]->setCreatedAt(new \DateTime());
                $styles[$i]->setUpdatedAt(new \DateTime());
                $styles[$i]->setEnabled(true);
                $content = $this->randomTexts[array_rand($this->randomTexts)];;
                $styles[$i]->setContentFormatter('richhtml');
                $styles[$i]->setRawContent($content);
                $styles[$i]->setContent($content);
                $this->addRandomTags($styles[$i]);

                $manager->persist($styles[$i]);

                // Ranks
                for ($j = 1; $j <= mt_rand(1, 20); $j++) {
                    $ranks[$i . '-' . $j] = new Rank();
                    $ranks[$i . '-' . $j]->setTitle('Rank ' . $i . '-' . $j);
                    $ranks[$i . '-' . $j]->setPublicationDateStart(new \DateTime());
                    $ranks[$i . '-' . $j]->setCreatedAt(new \DateTime());
                    $ranks[$i . '-' . $j]->setUpdatedAt(new \DateTime());
                    $ranks[$i . '-' . $j]->setEnabled(true);
                    $content = $this->randomTexts[array_rand($this->randomTexts)];;
                    $ranks[$i . '-' . $j]->setContentFormatter('richhtml');
                    $ranks[$i . '-' . $j]->setRawContent($content);
                    $ranks[$i . '-' . $j]->setContent($content);
                    $this->addRandomTags($ranks[$i . '-' . $j]);

                    $ranks[$i . '-' . $j]->setLevel($j);
                    $styles[$i]->addRank($ranks[$i . '-' . $j]);
                }
            }

            $manager->flush();

            foreach ($ranks as $key => $rank) {
                // RankHolders
                $randomUsers = $users;
                for ($k = 1; $k <= mt_rand(1, 10); $k++) {
                    $rankHolders[$key.'-'.$k] = new RankHolder();
                    $rankHolders[$key.'-'.$k]->setPromotedAt($this->generateDate());
                    $rankHolders[$key.'-'.$k]->setJury('Jury '.$key.'-'.$k);

                    $randomUser = $randomUsers[array_rand($randomUsers)];
                    $randomUser->addRank($rankHolders[$key.'-'.$k]);
                    unset($randomUsers[array_search($randomUser, $randomUsers)]);

                    $rank->addHolder($rankHolders[$key.'-'.$k]);
                }

                $randomExercises = $exercises;
                // RankRequirements
                for ($k = 1; $k <= mt_rand(2, 10); $k++) {
                    $rankRequirements[$key.'-'.$k] = new RankRequirement();
                    $rankRequirements[$key.'-'.$k]->setPoints(mt_rand(5,30));
                    $rankRequirements[$key.'-'.$k]->setDetail('Detail '.$key.'-'.$k);

                    $randomExercise = $randomExercises[array_rand($randomExercises)];
                    $randomExercise->addRankRequirement($rankRequirements[$key.'-'.$k]);
                    unset($randomExercises[array_search($randomExercise, $randomExercises)]);

                    $rank->addRankRequirement($rankRequirements[$key.'-'.$k]);
                }
            }

            // FAQs
            for ($i = $loop + 1; $i <= $loop + 1; $i++) {
                $faqs[$i] = new FAQ();
                $faqs[$i]->setTitle('Faq '.$i);
                $faqs[$i]->setPublicationDateStart(new \DateTime());
                $faqs[$i]->setCreatedAt(new \DateTime());
                $faqs[$i]->setUpdatedAt(new \DateTime());
                $faqs[$i]->setEnabled(true);
                $content = $this->randomTexts[array_rand($this->randomTexts)];;
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

            // Shows
            for ($i = $loop + 1; $i <= $loop + 1; $i++) {
                $shows[$i] = new Show();
                $shows[$i]->setTitle('Show '.$i);
                $shows[$i]->setPublicationDateStart(new \DateTime());
                $shows[$i]->setCreatedAt(new \DateTime());
                $shows[$i]->setUpdatedAt(new \DateTime());
                $shows[$i]->setEnabled(true);
                $content = $this->randomTexts[array_rand($this->randomTexts)];;
                $shows[$i]->setContentFormatter('richhtml');
                $shows[$i]->setRawContent($content);
                $shows[$i]->setContent($content);
                $this->addRandomTags($shows[$i]);

                $shows[$i]->setStartDate(new \DateTime());
                $shows[$i]->setEndDate(new \DateTime());
                $shows[$i]->setAddress('Show address '.$i);

                // Participants
                $randomUsers = $users;
                for ($j = 1; $j <= mt_rand(2, 12); $j++) {
                    $participants[$i.'-'.$j] = new Participant();
                    $participants[$i.'-'.$j]->setFirstname('Firstname show '.$i.'-'.$j);
                    $participants[$i.'-'.$j]->setLastname('Lastname show '.$i.'-'.$j);
                    $participants[$i.'-'.$j]->setPhone($this->generatePhoneNumber());
                    $participants[$i.'-'.$j]->setDateOfBirth($this->generateDate());
                    $participants[$i.'-'.$j]->setGender($this->genders[array_rand($this->genders)]);
                    $participants[$i.'-'.$j]->setAddress('Participant show address '.$i.'-'.$j);

                    $randomUser = $randomUsers[array_rand($randomUsers)];
                    $randomUser2 = $randomUsers[array_rand($randomUsers)];
                    $participants[$i.'-'.$j]->setUser($randomUser);
                    $participants[$i.'-'.$j]->setRegistrant($randomUser2);
                    unset($randomUsers[array_search($randomUser, $randomUsers)]);
                    unset($randomUsers[array_search($randomUser2, $randomUsers)]);

                    $participants[$i.'-'.$j]->setHost((bool)mt_rand(0, 1));

                    $shows[$i]->addParticipant($participants[$i.'-'.$j]);
                }

                $manager->persist($shows[$i]);
            }

            // TrainingCourses
            for ($i = $loop + 1; $i <= $loop + 1; $i++) {
                $trainingCourses[$i] = new TrainingCourse();
                $trainingCourses[$i]->setTitle('Training course '.$i);
                $trainingCourses[$i]->setPublicationDateStart(new \DateTime());
                $trainingCourses[$i]->setCreatedAt(new \DateTime());
                $trainingCourses[$i]->setUpdatedAt(new \DateTime());
                $trainingCourses[$i]->setEnabled(true);
                $content = $this->randomTexts[array_rand($this->randomTexts)];;
                $trainingCourses[$i]->setContentFormatter('richhtml');
                $trainingCourses[$i]->setRawContent($content);
                $trainingCourses[$i]->setContent($content);
                $this->addRandomTags($trainingCourses[$i]);

                $trainingCourses[$i]->setStartDate(new \DateTime());
                $trainingCourses[$i]->setEndDate(new \DateTime());
                $trainingCourses[$i]->setAddress('Training course address '.$i);

                // Participants
                $randomUsers = $users;
                for ($j = 1; $j <= mt_rand(2, 12); $j++) {
                    $participants[$i.'-'.$j] = new Participant();
                    $participants[$i.'-'.$j]->setFirstname('Firstname training course '.$i.'-'.$j);
                    $participants[$i.'-'.$j]->setLastname('Lastname training course '.$i.'-'.$j);
                    $participants[$i.'-'.$j]->setPhone($this->generatePhoneNumber());
                    $participants[$i.'-'.$j]->setDateOfBirth($this->generateDate());
                    $participants[$i.'-'.$j]->setGender($this->genders[array_rand($this->genders)]);
                    $participants[$i.'-'.$j]->setAddress('Participant training course address '.$i.'-'.$j);

                    $randomUser = $randomUsers[array_rand($randomUsers)];
                    $randomUser2 = $randomUsers[array_rand($randomUsers)];
                    $participants[$i.'-'.$j]->setUser($randomUser);
                    $participants[$i.'-'.$j]->setRegistrant($randomUser2);
                    unset($randomUsers[array_search($randomUser, $randomUsers)]);
                    unset($randomUsers[array_search($randomUser2, $randomUsers)]);

                    $participants[$i.'-'.$j]->setTrainer((bool)mt_rand(0, 1));

                    $trainingCourses[$i]->addParticipant($participants[$i.'-'.$j]);
                }

                // Exercises
                for ($k = 1; $k <= mt_rand(0, 10); $k++) {
                    $trainingCourses[$i]->addExercise($exercises[array_rand($exercises)]);
                }

                $manager->persist($trainingCourses[$i]);
            }

            // Competitions
            for ($i = $loop + 1; $i <= $loop + 1; $i++) {
                $competitions[$i] = new Competition();
                $competitions[$i]->setTitle('Competition '.$i);
                $competitions[$i]->setPublicationDateStart(new \DateTime());
                $competitions[$i]->setCreatedAt(new \DateTime());
                $competitions[$i]->setUpdatedAt(new \DateTime());
                $competitions[$i]->setEnabled(true);
                $content = $this->randomTexts[array_rand($this->randomTexts)];;
                $competitions[$i]->setContentFormatter('richhtml');
                $competitions[$i]->setRawContent($content);
                $competitions[$i]->setContent($content);
                $this->addRandomTags($competitions[$i]);

                $competitions[$i]->setStartDate(new \DateTime());
                $competitions[$i]->setEndDate(new \DateTime());
                $competitions[$i]->setAddress('Competition address '.$i);

                // Participants
                $randomUsers = $users;
                for ($j = 1; $j <= mt_rand(2, 12); $j++) {
                    $participants[$i.'-'.$j] = new Participant();
                    $participants[$i.'-'.$j]->setFirstname('Firstname competition '.$i.'-'.$j);
                    $participants[$i.'-'.$j]->setLastname('Lastname competition '.$i.'-'.$j);
                    $participants[$i.'-'.$j]->setPhone($this->generatePhoneNumber());
                    $participants[$i.'-'.$j]->setDateOfBirth($this->generateDate());
                    $participants[$i.'-'.$j]->setGender($this->genders[array_rand($this->genders)]);
                    $participants[$i.'-'.$j]->setAddress('Participant competition address '.$i.'-'.$j);

                    $randomUser = $randomUsers[array_rand($randomUsers)];
                    $randomUser2 = $randomUsers[array_rand($randomUsers)];
                    $participants[$i.'-'.$j]->setUser($randomUser);
                    $participants[$i.'-'.$j]->setRegistrant($randomUser2);
                    unset($randomUsers[array_search($randomUser, $randomUsers)]);
                    unset($randomUsers[array_search($randomUser2, $randomUsers)]);

                    $participants[$i.'-'.$j]->setReferee((bool)mt_rand(0, 1));

                    $competitions[$i]->addParticipant($participants[$i.'-'.$j]);
                }

                // Trials
                for ($j = 1; $j <= mt_rand(1, 10); $j++) {
                    $trials[$i.'-'.$j] = new Trial();
                    $trials[$i.'-'.$j]->setName('Trial '.$i.'-'.$j);
                    $content = $this->randomTexts[array_rand($this->randomTexts)];;
                    $trials[$i.'-'.$j]->setRulesFormatter('richhtml');
                    $trials[$i.'-'.$j]->setRawRules($content);
                    $trials[$i.'-'.$j]->setRules($content);

                    $competitions[$i]->addTrial($trials[$i.'-'.$j]);
                }

                $manager->persist($competitions[$i]);
            }

            $manager->flush();

            // TrialResults
            foreach ($trials as $key => $trial) {
                $randomParticipants = $trial->getCompetition()->getParticipants()->toArray();
                $countParticipants = mt_rand(2, count($randomParticipants));
                $trialDone = (bool)mt_rand(0, 1);
                for ($k = 1; $k <= $countParticipants; $k++) {
                    $trialResults[$key.'-'.$k] = new TrialResult();
                    if (!$trialDone) {
                        $trialResults[$key.'-'.$k]->setPlace(null);
                    } else {
                        $trialResults[$key.'-'.$k]->setPlace($k);
                    }
                    $trial->addTrialResult($trialResults[$key.'-'.$k]);

                    $randomParticipant = $randomParticipants[array_rand($randomParticipants)];
                    $randomParticipant->addTrialResult($trialResults[$key.'-'.$k]);
                    unset($randomParticipants[array_search($randomParticipant, $randomParticipants)]);
                }
            }

            // Galleries
            for ($i = $loop + 1; $i <= $loop + 1; $i++) {
                $context = $this->contexts[array_rand($this->contexts)]->getId();
                $galleries[$i] = new Gallery();
                $galleries[$i]->setName('Gallery '.$i);
                $galleries[$i]->setContext($context);
                $galleries[$i]->setCreatedAt(new \DateTime());
                $galleries[$i]->setUpdatedAt(new \DateTime());
                $galleries[$i]->setEnabled(true);

                $providers = $this->container->get('sonata.media.pool')->getProvidersByContext($context);

                // Medias
                for ($j = 1; $j <= mt_rand(2, 20); $j++) {
                    $medias[$i.'-'.$j] = $mediaManager->create();
                    $medias[$i.'-'.$j]->setContext($context);
                    $medias[$i.'-'.$j]->setCreatedAt(new \DateTime());
                    $medias[$i.'-'.$j]->setUpdatedAt(new \DateTime());
                    $medias[$i.'-'.$j]->setEnabled(true);

                    $provider = $providers[array_rand($providers)];
                    $medias[$i.'-'.$j]->setProviderName($provider->getName());
                    $medias[$i.'-'.$j]->setBinaryContent($this->generateMediaContent($provider->getName(), $i.'-'.$j));

                    // GalleryHasMedias
                    $galleryHasMedias[$i.'-'.$j] = new GalleryHasMedia();
                    $galleryHasMedias[$i.'-'.$j]->setEnabled(true);
                    $galleryHasMedias[$i.'-'.$j]->setPosition($j);
                    $galleryHasMedias[$i.'-'.$j]->setCreatedAt(new \DateTime());
                    $galleryHasMedias[$i.'-'.$j]->setUpdatedAt(new \DateTime());
                    $galleryHasMedias[$i.'-'.$j]->setMedia($medias[$i.'-'.$j]);

                    $galleries[$i]->addGalleryHasMedias($galleryHasMedias[$i.'-'.$j]);
                }

                $manager->persist($galleries[$i]);
            }

            $manager->flush();

            // Clear memory, the next loop iteration will start
            $manager->clear();
            unset($users);
            unset($supplies);
            unset($techniques);
            unset($exercises);
            unset($techniqueExecutions);
            unset($styles);
            unset($ranks);
            unset($rankHolders);
            unset($rankRequirements);
            unset($faqs);
            unset($questions);
            unset($participants);
            unset($shows);
            unset($trainingCourses);
            unset($competitions);
            unset($trials);
            unset($trialResults);
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
     * @param string $file
     * @param int    $minWidth
     * @param int    $maxWidth
     * @param int    $minHeight
     * @param int    $maxHeight
     *
     * @return File
     */
    private function generateImage($file, $minWidth = 50, $maxWidth = 1024, $minHeight = 50, $maxHeight = 1024)
    {
        $fileName = $this->uploadPath.'/'.$file.'.jpg';
        if (!file_exists($fileName)) {
            $width = mt_rand((int) $minWidth, (int) $maxWidth);
            $height = mt_rand((int) $minHeight, (int) $maxHeight);
            $url = 'https://picsum.photos/'.$width.'/'.$height.'?random';
            $image = file_get_contents($url);
            file_put_contents($fileName, $image);
        }

        return new File($fileName);
    }

    /**
     * TODO use API to fetch random videos
     *
     * @return File
     */
    private function generateYoutubeVideo()
    {
        $randomUrls = [
            'https://www.youtube.com/watch?v=rSTrjlRPyBU',
            'https://www.youtube.com/watch?v=QtplRk6BdyA',
            'https://www.youtube.com/watch?v=iHIBt4L9NAI',
            'https://www.youtube.com/watch?v=qDY-DF4Lpdg',
            'https://www.youtube.com/watch?v=hTqZe7STKFk',
            'https://www.youtube.com/watch?v=M5X_Ijxm2bw',
            'https://www.youtube.com/watch?v=NLl-AErqAc8',
            'https://www.youtube.com/watch?v=e4jXoLRTa58',
            'https://www.youtube.com/watch?v=chx8lIk9nNI',
            'https://www.youtube.com/watch?v=SZLXgoxXRLI',
        ];

//        return new File(file_get_contents($randomUrls[array_rand($randomUrls)]));
        return $randomUrls[array_rand($randomUrls)];
    }

    /**
     * TODO use API to fetch random videos
     *
     * @return File
     */
    private function generateDailymotionVideo()
    {
        $randomUrls = [
            'xqk18h',
            'x382l5l',
            'x15xsu6',
            'xhruu7',
            'xhruu7',
            'xsbjen',
            'x116sy9',
            'xh71ch',
            'x28v3e',
        ];

//        return new File(file_get_contents($randomUrls[array_rand($randomUrls)]));
        return $randomUrls[array_rand($randomUrls)];
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
     * @param string $countryCode
     * @param int    $digitsNumber
     *
     * @return string
     */
    private function generatePhoneNumber($countryCode = '+33', $digitsNumber = 9)
    {
        return $countryCode.mt_rand(pow(10, $digitsNumber-1), pow(10, $digitsNumber)-1);
    }

    /**
     * @param string $providerName
     *
     * @return File|null
     */
    private function generateMediaContent($providerName = 'sonata.media.provider.image', $uniqueId = null)
    {
        switch ($providerName) {
            case 'sonata.media.provider.image':

                return $this->generateImage($uniqueId);
                break;
            case 'sonata.media.provider.youtube':

                return $this->generateYoutubeVideo();
                break;
            case 'sonata.media.provider.dailymotion':

                return $this->generateDailymotionVideo();
                break;
        }

        return null;
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
