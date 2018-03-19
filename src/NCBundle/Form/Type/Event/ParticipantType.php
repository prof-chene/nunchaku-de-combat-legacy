<?php

namespace NCBundle\Form\Type\Event;

use Application\Sonata\UserBundle\Entity\User;
use NCBundle\Entity\Event\Competition;
use NCBundle\Entity\Event\Participant;
use NCBundle\Entity\Event\Show;
use NCBundle\Entity\Event\TrainingCourse;
use NCBundle\Entity\Event\Trial;
use NCBundle\Repository\Event\TrialRepository;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Sonata\UserBundle\Form\Type\UserGenderListType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ParticipantType
 *
 * @package NCBundle\Form\Event
 */
class ParticipantType extends AbstractType
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var TrialRepository
     */
    private $trialRepository;

    /**
     * ParticipantType constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param TrialRepository       $trialRepository
     */
    public function __construct(TokenStorageInterface $tokenStorage, TrialRepository $trialRepository)
    {
        $this->tokenStorage    = $tokenStorage;
        $this->trialRepository = $trialRepository;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', null, [
                'label'    => 'lastname',
                'required' => true,
            ])
            ->add('firstname', null, [
                'label'    => 'firstname',
                'required' => true,
            ])
            ->add('phone', null, [
                'label'    => 'phone',
                'required' => true,
            ])
            ->add('dateOfBirth', null, [
                'label'    => 'date_of_birth',
                'required' => true,
            ]);

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $formEvent) {
            $participant = $formEvent->getData();
            $event = $participant->getEvent();
            $form = $formEvent->getForm();

            if ($this->tokenStorage->getToken()->getUser() instanceof User) {
                $user = $this->tokenStorage->getToken()->getUser();
                $participant->setRegistrant($user);
                $participant->setLastName($user->getLastName());
                $participant->setFirstName($user->getFirstName());
                $participant->setPhone($user->getPhone());
                $participant->setDateOfBirth($user->getDateOfBirth());
                $form->add('itsMe', ChoiceType::class, [
                    'required' => true,
                    'expanded' => true,
                    'choices'  => [
                        'register_me'      => true,
                        'register_someone' => false,
                    ],
                    'mapped' => false,
                ]);
            }

            if ($event instanceof Competition) {
                if (!empty($user)) {
                    $participant->setGender($user->getGender());
                }
                $form->add('gender', UserGenderListType::class, [
                    'label'    => 'gender',
                    'required' => true,
                ]);

                $trials = $this->trialRepository->findBy(['competition' => $event]);
                $form->add('trials', EntityType::class, [
                    'label'        => 'pick_trials',
                    'required'     => true,
                    'expanded'     => true,
                    'multiple'     => true,
                    'mapped'       => false,
                    'class'        => Trial::class,
                    'choice_label' => 'name',
                    'choices'      => $trials,
                ]);
                $form->add('referee', null, [
                    'label' => 'able_to_referee',
                ]);
            } elseif ($event instanceof TrainingCourse) {
                $form->add('trainer', null, [
                    'label' => 'i_am_trainer',
                ]);
            } elseif ($event instanceof Show) {
                $form->add('host', null, [
                    'label' => 'i_am_host',
                ]);
            }
        });
        $builder->add('submit', SubmitType::class, [
            'label' => 'validate'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
