<?php

namespace NCBundle\Admin\Event;

use NCBundle\Entity\Event\Participant;
use NCBundle\Entity\Event\TrialResult;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class TrialResultAdmin
 *
 * @package NCBundle\Admin\Event
 */
class TrialResultAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_trial_result';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'trialResult';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('trial', 'sonata_type_model', array(
                'class' => 'NCBundle\Entity\Event\Trial',
                'property' => 'name',
                'required' => true,
            ))
            ->add('participant', 'sonata_type_model', array(
                'class' => 'NCBundle\Entity\Event\Participant',
                'property' => function (Participant $participant) {
                    return $participant->getFirstname() . ' ' . $participant->getLastname();
                },
                'required' => true,
            ))
            ->add('place');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('trial.name')
            ->add('participant.lastname')
            ->add('participant.firstname')
            ->add('place');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('participant', null, array(
                'associated_property' => 'name',))
            ->add('rules')
            ->add('competition', null, array(
                'associated_property' => 'name',
            ))
            ->add('trialResults', null, array(
                'associated_property' => function (TrialResult $result) {
                    return $result->getParticipant()->getLastname() . ' ' . $result->getParticipant()->getFirstname() .
                    ' : ' . $result->getPlace();
                },
            ));
    }
}
