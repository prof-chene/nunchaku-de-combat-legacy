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
 */
class TrialResultAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected  $translationDomain = 'admin';
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_trial_result';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'trialResult';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('trial', 'sonata_type_model_autocomplete', [
                'property' => 'name',
                'required' => true,
                'minimum_input_length' => 2,
                'quiet_millis' => 500,
            ])
            ->add('participant', 'sonata_type_model_autocomplete', [
                'property' => ['lastname', 'firstname'],
                'required' => true,
                'minimum_input_length' => 2,
                'quiet_millis' => 500,
            ])
            ->add('place');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('trial.id')
            ->add('trial.competition', 'doctrine_orm_model_autocomplete', [], null, [
                'property' => 'title',
                'minimum_input_length' => 2,
                'quiet_millis' => 500,
            ])
            ->add('trial', 'doctrine_orm_model_autocomplete', [], null, [
                'property' => 'name',
                'minimum_input_length' => 2,
                'quiet_millis' => 500,
            ])
            ->add('participant', 'doctrine_orm_model_autocomplete', [], null, [
                'property' => ['lastname', 'firstname'],
                'minimum_input_length' => 2,
                'quiet_millis' => 500,
            ])
            ->add('place');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('trial.id')
            ->addIdentifier('trial.competition.title')
            ->add('trial.name')
            ->add('participant')
            ->add('place');
    }
}
