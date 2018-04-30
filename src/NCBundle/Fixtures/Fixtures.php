<?php

namespace NCBundle\Fixtures;

use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\ClassificationBundle\Entity\Collection;
use Application\Sonata\ClassificationBundle\Entity\Context;
use Application\Sonata\ClassificationBundle\Entity\Tag;
use Application\Sonata\MediaBundle\Entity\Gallery;
use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;
use Application\Sonata\NewsBundle\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use NCBundle\Entity\Event\Competition;
use NCBundle\Entity\Event\Participant;
use NCBundle\Entity\Event\Show;
use NCBundle\Entity\Event\TrainingCourse;
use NCBundle\Entity\Event\Trial;
use NCBundle\Entity\Event\TrialResult;
use NCBundle\Entity\Information\Club;
use NCBundle\Entity\Information\FAQ;
use NCBundle\Entity\Information\Question;
use NCBundle\Entity\Information\ScheduledLesson;
use NCBundle\Entity\Information\SocialMediaAccount;
use NCBundle\Entity\Information\Trainer;
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
        // Create upload dirs if they don't exist
        if (!is_readable($this->container->get('kernel')->getRootDir() . '/../web/uploads')) {
            mkdir($this->container->get('kernel')->getRootDir() . '/../web/uploads');
        }
        if (!is_readable($this->container->get('kernel')->getRootDir() . '/../web/uploads/media')) {
            mkdir($this->container->get('kernel')->getRootDir() . '/../web/uploads/media');
        }
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
        $userManager = $this->container->get('sonata.user.manager.user');
        /**
         * @var MediaManager
         */
        $mediaManager = $this->container->get('sonata.media.manager.media');

        // Superadmin
        $superadmin = $userManager->create();
        $superadmin->setUsername('superadmin');
        $superadmin->setFirstname('Firstname superadmin');
        $superadmin->setLastname('Lastname superadmin');
        $superadmin->setEmail('superadmin@test.com');
        $superadmin->setPlainPassword('superadmin');
        $superadmin->setEnabled(true);
        $superadmin->addRole('ROLE_SUPER_ADMIN');
        $userManager->save($superadmin, false);

        // Genders
        $this->genders = $superadmin->getGenderList();

        // Contexts
        $contextNames = ['blog', 'club', 'event', 'exercise', 'technique'];
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

        unset($tags);

        $socialMedias = ['facebook', 'google', 'instagram', 'pinterest', 'reddit', 'soundcloud', 'tumblr', 'twitter'];
        $dayNames = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        for ($loop = 0; $loop <= 19; $loop++) {
            printf('===============================');
            printf('Loop '.($loop+1));
            // Tags and contexts are flushed from entityManager, we have to fetch them every time
            $contexts = $manager->getRepository(Context::class)->findAll();
            foreach ($contexts as $context) {
                $this->contexts[$context->getId()] = $context;
            }
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
                $content = $this->randomTexts[array_rand($this->randomTexts)];
                $supplies[$i]->setContentFormatter('richhtml');
                $supplies[$i]->setRawContent($content);
                $supplies[$i]->setContent($content);
                $this->addRandomTags($supplies[$i]);

                $manager->persist($supplies[$i]);
            }

            // Collection Technique
            $techniqueCollection = new Collection();
            $techniqueCollection->setEnabled(true);
            $techniqueCollection->setContext($this->contexts['technique']);
            $techniqueCollection->setName('Collection Technique '.($loop + 1));
            $techniqueCollection->setCreatedAt(new \DateTime());
            $techniqueCollection->setUpdatedAt(new \DateTime());
            $techniqueCollection->setDescription('Description Technique '.($loop + 1));

            $techniqueCollectionMedia = $mediaManager->create();
            $techniqueCollectionMedia->setContext('technique');
            $techniqueCollectionMedia->setCreatedAt(new \DateTime());
            $techniqueCollectionMedia->setUpdatedAt(new \DateTime());
            $techniqueCollectionMedia->setEnabled(true);
            $techniqueCollectionMedia->setProviderName('sonata.media.provider.image');
            $techniqueCollectionMedia->setBinaryContent($this->generateMediaContent('sonata.media.provider.image', 'TechniqueCollection-'.($loop + 1)));
            $techniqueCollection->setMedia($techniqueCollectionMedia);

            $manager->persist($techniqueCollection);

            // Collection Exercise
            $exerciseCollection = new Collection();
            $exerciseCollection->setEnabled(true);
            $exerciseCollection->setContext($this->contexts['exercise']);
            $exerciseCollection->setName('Collection Exercise '.($loop + 1));
            $exerciseCollection->setCreatedAt(new \DateTime());
            $exerciseCollection->setUpdatedAt(new \DateTime());
            $exerciseCollection->setDescription('Description Exercise '.($loop + 1));

            $exerciseCollectionMedia = $mediaManager->create();
            $exerciseCollectionMedia->setContext('exercise');
            $exerciseCollectionMedia->setCreatedAt(new \DateTime());
            $exerciseCollectionMedia->setUpdatedAt(new \DateTime());
            $exerciseCollectionMedia->setEnabled(true);
            $exerciseCollectionMedia->setProviderName('sonata.media.provider.image');
            $exerciseCollectionMedia->setBinaryContent($this->generateMediaContent('sonata.media.provider.image', 'ExerciseCollection-'.($loop + 1)));
            $exerciseCollection->setMedia($exerciseCollectionMedia);

            $manager->persist($exerciseCollection);

            // Techniques
            for ($i = ($loop * 10) + 1; $i <= ($loop * 10) + 10; $i++) {
                $techniques[$i] = new Technique();
                $techniques[$i]->setTitle('Technique '.$i);
                $techniques[$i]->setPublicationDateStart(new \DateTime());
                $techniques[$i]->setCreatedAt(new \DateTime());
                $techniques[$i]->setUpdatedAt(new \DateTime());
                $techniques[$i]->setEnabled(true);
                $content = $this->randomTexts[array_rand($this->randomTexts)];
                $techniques[$i]->setContentFormatter('richhtml');
                $techniques[$i]->setRawContent($content);
                $techniques[$i]->setContent($content);
                $this->addRandomTags($techniques[$i]);

                $techniques[$i]->setCollection($techniqueCollection);

                $techniqueImages[$i] = $mediaManager->create();
                $techniqueImages[$i]->setContext('technique');
                $techniqueImages[$i]->setCreatedAt(new \DateTime());
                $techniqueImages[$i]->setUpdatedAt(new \DateTime());
                $techniqueImages[$i]->setEnabled(true);
                $techniqueImages[$i]->setProviderName('sonata.media.provider.image');
                $techniqueImages[$i]->setBinaryContent($this->generateMediaContent('sonata.media.provider.image', 'Technique-'.$i));
                $techniques[$i]->setImage($techniqueImages[$i]);

                // Exercises
                for ($j = 1; $j <= mt_rand(1, 4); $j++) {
                    $exercises[$i.'-'.$j] = new Exercise();
                    $exercises[$i.'-'.$j]->setTitle('Exercise '.$i.'-'.$j);
                    $exercises[$i.'-'.$j]->setPublicationDateStart(new \DateTime());
                    $exercises[$i.'-'.$j]->setCreatedAt(new \DateTime());
                    $exercises[$i.'-'.$j]->setUpdatedAt(new \DateTime());
                    $exercises[$i.'-'.$j]->setEnabled(true);
                    $content = $this->randomTexts[array_rand($this->randomTexts)];
                    $exercises[$i.'-'.$j]->setContentFormatter('richhtml');
                    $exercises[$i.'-'.$j]->setRawContent($content);
                    $exercises[$i.'-'.$j]->setContent($content);
                    $this->addRandomTags($exercises[$i.'-'.$j]);

                    for ($k = 1; $k <= mt_rand(0, 2); $k++) {
                        $exercises[$i.'-'.$j]->addSupply($supplies[array_rand($supplies)]);
                    }

                    $exercises[$i.'-'.$j]->setCollection($exerciseCollection);

                    $exerciseImages[$i.'-'.$j] = $mediaManager->create();
                    $exerciseImages[$i.'-'.$j]->setContext('exercise');
                    $exerciseImages[$i.'-'.$j]->setCreatedAt(new \DateTime());
                    $exerciseImages[$i.'-'.$j]->setUpdatedAt(new \DateTime());
                    $exerciseImages[$i.'-'.$j]->setEnabled(true);
                    $exerciseImages[$i.'-'.$j]->setProviderName('sonata.media.provider.image');
                    $exerciseImages[$i.'-'.$j]->setBinaryContent($this->generateMediaContent('sonata.media.provider.image', 'Exercise-'.$i.'-'.$j));
                    $exercises[$i.'-'.$j]->setImage($exerciseImages[$i.'-'.$j]);

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
                $content = $this->randomTexts[array_rand($this->randomTexts)];
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
                    $content = $this->randomTexts[array_rand($this->randomTexts)];
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
                $content = $this->randomTexts[array_rand($this->randomTexts)];
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
                $content = $this->randomTexts[array_rand($this->randomTexts)];
                $shows[$i]->setContentFormatter('richhtml');
                $shows[$i]->setRawContent($content);
                $shows[$i]->setContent($content);
                $this->addRandomTags($shows[$i]);

                $randomDateTime[$i] = (new \DateTime())->add(date_interval_create_from_date_string(mt_rand(0, 1).' year'));
                $shows[$i]->setStartDate($randomDateTime[$i]);
                $shows[$i]->setEndDate($randomDateTime[$i]);
                $shows[$i]->setAddress('Show address '.$i);

                $showImages[$i] = $mediaManager->create();
                $showImages[$i]->setContext('event');
                $showImages[$i]->setCreatedAt(new \DateTime());
                $showImages[$i]->setUpdatedAt(new \DateTime());
                $showImages[$i]->setEnabled(true);
                $showImages[$i]->setProviderName('sonata.media.provider.image');
                $showImages[$i]->setBinaryContent($this->generateMediaContent('sonata.media.provider.image', 'Show-'.$i));
                $shows[$i]->setImage($showImages[$i]);

                // Participants
                $randomUsers = $users;
                for ($j = 1; $j <= mt_rand(2, 12); $j++) {
                    $showParticipants[$i.'-'.$j] = new Participant();

                    $randomUser = $randomUsers[array_rand($randomUsers)];
                    $randomUser2 = $randomUsers[array_rand($randomUsers)];
                    $showParticipants[$i.'-'.$j]->setUser($randomUser);
                    $showParticipants[$i.'-'.$j]->setRegistrant($randomUser2);
                    unset($randomUsers[array_search($randomUser, $randomUsers)]);
                    unset($randomUsers[array_search($randomUser2, $randomUsers)]);

                    $showParticipants[$i.'-'.$j]->setFirstname($showParticipants[$i.'-'.$j]->getUser()->getFirstname());
                    $showParticipants[$i.'-'.$j]->setLastname($showParticipants[$i.'-'.$j]->getUser()->getLastname());
                    $showParticipants[$i.'-'.$j]->setPhone($this->generatePhoneNumber());
                    $showParticipants[$i.'-'.$j]->setDateOfBirth($this->generateDate());
                    $showParticipants[$i.'-'.$j]->setAddress('Participant show address '.$i.'-'.$j);

                    $showParticipants[$i.'-'.$j]->setHost((bool)mt_rand(0, 1));

                    $shows[$i]->addParticipant($showParticipants[$i.'-'.$j]);
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
                $content = $this->randomTexts[array_rand($this->randomTexts)];
                $trainingCourses[$i]->setContentFormatter('richhtml');
                $trainingCourses[$i]->setRawContent($content);
                $trainingCourses[$i]->setContent($content);
                $this->addRandomTags($trainingCourses[$i]);

                $randomDateTime[$i] = (new \DateTime())->add(date_interval_create_from_date_string(mt_rand(0, 1).' year'));
                $trainingCourses[$i]->setStartDate($randomDateTime[$i]);
                $trainingCourses[$i]->setEndDate($randomDateTime[$i]);
                $trainingCourses[$i]->setAddress('Training course address '.$i);

                $trainingCourseImages[$i] = $mediaManager->create();
                $trainingCourseImages[$i]->setContext('event');
                $trainingCourseImages[$i]->setCreatedAt(new \DateTime());
                $trainingCourseImages[$i]->setUpdatedAt(new \DateTime());
                $trainingCourseImages[$i]->setEnabled(true);
                $trainingCourseImages[$i]->setProviderName('sonata.media.provider.image');
                $trainingCourseImages[$i]->setBinaryContent($this->generateMediaContent('sonata.media.provider.image', 'TrainingCourse-'.$i));
                $trainingCourses[$i]->setImage($trainingCourseImages[$i]);

                // Participants
                $randomUsers = $users;
                for ($j = 1; $j <= mt_rand(2, 12); $j++) {
                    $trainingCourseParticipants[$i.'-'.$j] = new Participant();

                    $randomUser = $randomUsers[array_rand($randomUsers)];
                    $randomUser2 = $randomUsers[array_rand($randomUsers)];
                    $trainingCourseParticipants[$i.'-'.$j]->setUser($randomUser);
                    $trainingCourseParticipants[$i.'-'.$j]->setRegistrant($randomUser2);
                    unset($randomUsers[array_search($randomUser, $randomUsers)]);
                    unset($randomUsers[array_search($randomUser2, $randomUsers)]);

                    $trainingCourseParticipants[$i.'-'.$j]->setFirstname($trainingCourseParticipants[$i.'-'.$j]->getUser()->getFirstname());
                    $trainingCourseParticipants[$i.'-'.$j]->setLastname($trainingCourseParticipants[$i.'-'.$j]->getUser()->getLastname());
                    $trainingCourseParticipants[$i.'-'.$j]->setPhone($this->generatePhoneNumber());
                    $trainingCourseParticipants[$i.'-'.$j]->setDateOfBirth($this->generateDate());
                    $trainingCourseParticipants[$i.'-'.$j]->setAddress('Participant training course address '.$i.'-'.$j);

                    $trainingCourseParticipants[$i.'-'.$j]->setTrainer((bool)mt_rand(0, 1));

                    $trainingCourses[$i]->addParticipant($trainingCourseParticipants[$i.'-'.$j]);
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
                $content = $this->randomTexts[array_rand($this->randomTexts)];
                $competitions[$i]->setContentFormatter('richhtml');
                $competitions[$i]->setRawContent($content);
                $competitions[$i]->setContent($content);
                $this->addRandomTags($competitions[$i]);

                $randomDateTime[$i] = (new \DateTime())->add(date_interval_create_from_date_string(mt_rand(0, 1).' year'));
                $competitions[$i]->setStartDate($randomDateTime[$i]);
                $competitions[$i]->setEndDate($randomDateTime[$i]);
                $competitions[$i]->setAddress('Competition address '.$i);

                $competitionImages[$i] = $mediaManager->create();
                $competitionImages[$i]->setContext('event');
                $competitionImages[$i]->setCreatedAt(new \DateTime());
                $competitionImages[$i]->setUpdatedAt(new \DateTime());
                $competitionImages[$i]->setEnabled(true);
                $competitionImages[$i]->setProviderName('sonata.media.provider.image');
                $competitionImages[$i]->setBinaryContent($this->generateMediaContent('sonata.media.provider.image', 'Competition-'.$i));
                $competitions[$i]->setImage($competitionImages[$i]);

                // Participants
                $randomUsers = $users;
                for ($j = 1; $j <= mt_rand(2, 12); $j++) {
                    $competitionParticipants[$i.'-'.$j] = new Participant();

                    $randomUser = $randomUsers[array_rand($randomUsers)];
                    $randomUser2 = $randomUsers[array_rand($randomUsers)];
                    $competitionParticipants[$i.'-'.$j]->setUser($randomUser);
                    $competitionParticipants[$i.'-'.$j]->setRegistrant($randomUser2);
                    unset($randomUsers[array_search($randomUser, $randomUsers)]);
                    unset($randomUsers[array_search($randomUser2, $randomUsers)]);

                    $competitionParticipants[$i.'-'.$j]->setFirstname($competitionParticipants[$i.'-'.$j]->getUser()->getFirstname());
                    $competitionParticipants[$i.'-'.$j]->setLastname($competitionParticipants[$i.'-'.$j]->getUser()->getLastname());
                    $competitionParticipants[$i.'-'.$j]->setPhone($this->generatePhoneNumber());
                    $competitionParticipants[$i.'-'.$j]->setDateOfBirth($this->generateDate());
                    $competitionParticipants[$i.'-'.$j]->setAddress('Participant competition address '.$i.'-'.$j);

                    $competitionParticipants[$i.'-'.$j]->setReferee((bool)mt_rand(0, 1));

                    $competitions[$i]->addParticipant($competitionParticipants[$i.'-'.$j]);
                }

                // Trials
                for ($j = 1; $j <= mt_rand(1, 10); $j++) {
                    $trials[$i.'-'.$j] = new Trial();
                    $trials[$i.'-'.$j]->setName('Trial '.$i.'-'.$j);
                    $content = $this->randomTexts[array_rand($this->randomTexts)];
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
                    $medias[$i.'-'.$j]->setBinaryContent($this->generateMediaContent($provider->getName(), 'Media-'.$i.'-'.$j));

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

            // Collection Blog
            $blogCollection = new Collection();
            $blogCollection->setEnabled(true);
            $blogCollection->setContext($this->contexts['blog']);
            $blogCollection->setName('Collection Blog '.($loop + 1));
            $blogCollection->setCreatedAt(new \DateTime());
            $blogCollection->setUpdatedAt(new \DateTime());
            $blogCollection->setDescription('Description Blog '.($loop + 1));

            $blogCollectionMedia = $mediaManager->create();
            $blogCollectionMedia->setContext('blog');
            $blogCollectionMedia->setCreatedAt(new \DateTime());
            $blogCollectionMedia->setUpdatedAt(new \DateTime());
            $blogCollectionMedia->setEnabled(true);
            $blogCollectionMedia->setProviderName('sonata.media.provider.image');
            $blogCollectionMedia->setBinaryContent($this->generateMediaContent('sonata.media.provider.image', 'BlogCollection-'.($loop + 1)));
            $blogCollection->setMedia($blogCollectionMedia);

            $manager->persist($blogCollection);

            // Posts
            for ($i = $loop + 1; $i <= $loop + 1; $i++) {
                $posts[$i] = new Post();
                $posts[$i]->setTitle('Post '.$i);
                $posts[$i]->setPublicationDateStart(new \DateTime());
                $posts[$i]->setCreatedAt(new \DateTime());
                $posts[$i]->setUpdatedAt(new \DateTime());
                $posts[$i]->setEnabled(true);
                $content = $this->randomTexts[array_rand($this->randomTexts)];
                $posts[$i]->setContentFormatter('richhtml');
                $posts[$i]->setRawContent($content);
                $posts[$i]->setContent($content);
                $this->addRandomTags($posts[$i]);

                $posts[$i]->setAbstract('Abstract '.$i);
                $posts[$i]->setAuthor($users[array_rand($users)]);
                $posts[$i]->setCommentsEnabled(true);
                $posts[$i]->setCommentsDefaultStatus(1);

                $posts[$i]->setCollection($blogCollection);

                $blogImages[$i] = $mediaManager->create();
                $blogImages[$i]->setContext('blog');
                $blogImages[$i]->setCreatedAt(new \DateTime());
                $blogImages[$i]->setUpdatedAt(new \DateTime());
                $blogImages[$i]->setEnabled(true);
                $blogImages[$i]->setProviderName('sonata.media.provider.image');
                $blogImages[$i]->setBinaryContent($this->generateMediaContent('sonata.media.provider.image', 'Post-'.$i));
                $posts[$i]->setImage($blogImages[$i]);

                $manager->persist($posts[$i]);
            }

            // Clubs
            for ($i = $loop + 1; $i <= $loop + 1; $i++) {
                $clubs[$i] = new Club();
                $clubs[$i]->setName('Club '.$i);
                $clubs[$i]->setPublicationDateStart(new \DateTime());
                $clubs[$i]->setCreatedAt(new \DateTime());
                $clubs[$i]->setUpdatedAt(new \DateTime());
                $clubs[$i]->setEnabled(true);
                $this->addRandomTags($clubs[$i]);

                $clubImages[$i] = $mediaManager->create();
                $clubImages[$i]->setContext('club');
                $clubImages[$i]->setCreatedAt(new \DateTime());
                $clubImages[$i]->setUpdatedAt(new \DateTime());
                $clubImages[$i]->setEnabled(true);
                $clubImages[$i]->setProviderName('sonata.media.provider.image');
                $clubImages[$i]->setBinaryContent($this->generateMediaContent('sonata.media.provider.image', 'Club-'.$i));
                $clubs[$i]->setImage($clubImages[$i]);

                $clubs[$i]->setPhone($this->generatePhoneNumber());
                $clubs[$i]->setAddress('Club address '.$i);
                $clubs[$i]->setWebsiteUrl('https://www.url-club'.$i.'.com');
                $clubs[$i]->setStyles($styles);

                // Trainers
                $randomUsers = $users;
                for ($j = 1; $j <= mt_rand(1, 5); $j++) {
                    $trainers[$i.'-'.$j] = new Trainer();
                    $randomUser = $randomUsers[array_rand($randomUsers)];
                    $trainers[$i.'-'.$j]->setUser($randomUser);
                    unset($randomUsers[array_search($randomUser, $randomUsers)]);

                    $trainers[$i.'-'.$j]->setFirstname($trainers[$i.'-'.$j]->getUser()->getFirstname());
                    $trainers[$i.'-'.$j]->setLastname($trainers[$i.'-'.$j]->getUser()->getLastname());
                    $trainers[$i.'-'.$j]->setCv($this->randomTexts[array_rand($this->randomTexts)]);

                    $clubs[$i]->addTrainer($trainers[$i.'-'.$j]);
                }

                // SocialMediaAccounts
                for ($j = 1; $j <= mt_rand(0, 10); $j++) {
                    $socialMediaAccounts[$i.'-'.$j] = new SocialMediaAccount();
                    $socialMediaAccounts[$i.'-'.$j]->setSocialMedia($socialMedias[array_rand($socialMedias)]);
                    $socialMediaAccounts[$i.'-'.$j]->setUrl('https://www.url-social-media-account'.$i.'-'.$j.'com');

                    $clubs[$i]->addSocialMediaAccount($socialMediaAccounts[$i.'-'.$j]);
                }

                // ScheduledLessons
                for ($j = 1; $j <= mt_rand(1, 5); $j++) {
                    $scheduledLessons[$i.'-'.$j] = new ScheduledLesson();
                    $scheduledLessons[$i.'-'.$j]->setDayOfTheWeek($dayNames[array_rand($dayNames)]);
                    $randomStartTime = new \DateTime(mt_rand(8, 19).':00');
                    $randomeEndTime = (clone $randomStartTime)->modify('+ '.mt_rand(1, 3).' hours');
                    $scheduledLessons[$i.'-'.$j]->setStartTime($randomStartTime);
                    $scheduledLessons[$i.'-'.$j]->setEndTime($randomeEndTime);
                    $scheduledLessons[$i.'-'.$j]->setDetails('Details '.$i.'-'.$j);

                    $clubs[$i]->addScheduledLesson($scheduledLessons[$i.'-'.$j]);
                }

                $manager->persist($clubs[$i]);
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
            unset($shows);
            unset($showParticipants);
            unset($trainingCourses);
            unset($trainingCourseParticipants);
            unset($competitions);
            unset($competitionParticipants);
            unset($trials);
            unset($trialResults);
            unset($galleries);
            unset($medias);
            unset($galleryHasMedias);
            unset($posts);
            unset($clubs);
            unset($trainers);
            unset($socialMediaAccounts);
            unset($scheduledLessons);
            unset($blogImages);
            unset($showImages);
            unset($trainingCourseImages);
            unset($competitionImages);
            unset($exerciseImages);
            unset($techniqueImages);
            unset($clubImages);
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
     * @param string      $providerName
     * @param string|null $file
     *
     * @return File|null
     */
    private function generateMediaContent($providerName = 'sonata.media.provider.image', $file = null)
    {
        switch ($providerName) {
            case 'sonata.media.provider.image':

                return $this->generateImage($file);
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
