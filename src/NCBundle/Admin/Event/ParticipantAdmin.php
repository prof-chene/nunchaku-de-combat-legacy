<?php

namespace NCBundle\Admin\Event;

use Application\Sonata\UserBundle\Entity\User;
use NCBundle\Entity\Event\TrialResult;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class ParticipantAdmin
 *
 * @package NCBundle\Admin\Event
 */
class ParticipantAdmin extends Admin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_participant';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'event';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('lastName', 'text')
            ->add('firstName', 'text')
            ->add('phone', 'text')
            ->add('dateOfBirth', 'date')
            ->add('gender', 'choice', array(
                'choices' => array(
                    'm' => 'male',
                    'f' => 'female',
                )
            ))
            ->add('address', 'textarea')
            ->add('user', 'sonata_type_model', array(
                'class' => 'Application\Sonata\UserBundle\Entity\User',
                'property' => 'name',
                'required' => false,
            ));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('lastname')
            ->add('firstname')
            ->add('phone')
            ->add('dateOfBirth')
            ->add('gender')
            ->add('address')
            ->add('user.lastName')
            ->add('user.firstname')
            ->add('trialResults.trial.competition.name');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('lastname')
            ->add('firstname')
            ->add('phone')
            ->add('dateOfBirth')
            ->add('gender')
            ->add('address')
            ->add('user', null, array(
                'associated_property' => function (User $user) {
                    return $user->getLastname() . ' ' . $user->getFirstname();
                },
            ))
            ->add('trialResults', null, array(
                'associated_property' => function (TrialResult $trialResult) {
                    return $trialResult->getTrial()->getEventCompetition()->getName() .
                    ' - ' . $trialResult->getTrial()->getName() .
                    ' : ' . $trialResult->getPlace();
                },
            ));
    }
}
