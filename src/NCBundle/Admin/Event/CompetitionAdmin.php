<?php

namespace NCBundle\Admin\Event;

use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class CompetitionAdmin
 */
class CompetitionAdmin extends AbstractEventAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_competition';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'competition';

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        parent::prePersist($object);
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getTrials() as $trial) {
            $trial->setCompetition($object);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        parent::preUpdate($object);
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getTrials() as $trial) {
            if (!$this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->contains($trial)) {
                $trial->setCompetition($object);
            }
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        $formMapper
            ->tab('tab_trials')
            ->with('')
            ->add('trials', 'sonata_type_collection', array(
                'required' => false,
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'link_parameters' => array(
                    'hide_context' => true,
                )
            ))
            ->end()
            ->end();
    }

}
