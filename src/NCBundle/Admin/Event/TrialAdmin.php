<?php

namespace NCBundle\Admin\Event;

use NCBundle\Entity\Event\TrialResult;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class TrialAdmin
 *
 * @package NCBundle\Admin\Event
 */
class TrialAdmin extends Admin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_trial';
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
            ->add('name', 'text')
            ->add('rules', 'textarea')
            ->add('competition', 'sonata_type_model', array(
                'class' => 'NCBundle\Entity\Event\EventCompetition',
                'property' => 'name',
                'required' => true,
            ))
            ->add('trialResults',
                'sonata_type_collection',
                array(
                    'type_options' => array(
                        'data_class' => 'NCBundle\Entity\Event\TrialResult',
                    )
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                )
            );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('rules')
            ->add('competition.name')
            ->add('trialResults.participant.lastname')
            ->add('trialResults.participant.firstname');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
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
