<?php

namespace NCBundle\Admin\Event;

use Application\Sonata\UserBundle\Entity\User;
use NCBundle\Entity\Event\TrialResult;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class ParticipantAdmin
 *
 * @package NCBundle\Admin\Event
 */
class ParticipantAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_participant';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'participant';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('lastname', 'text')
            ->add('firstname', 'text')
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
                    return $trialResult->getTrial()->getCompetition()->getName() .
                    ' - ' . $trialResult->getTrial()->getName() .
                    ' : ' . $trialResult->getPlace();
                },
            ));
    }
}
