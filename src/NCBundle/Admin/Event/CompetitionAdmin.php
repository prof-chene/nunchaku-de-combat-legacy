<?php

namespace NCBundle\Admin\Event;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class CompetitionAdmin
 *
 * @package NCBundle\Admin\Event
 */
class CompetitionAdmin extends AbstractEventAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_competition';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'competition';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        $formMapper
            ->tab('tab_trials')
            ->add('trials', 'sonata_type_collection', array(
                'required' => false,
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'link_parameters' => array(
                    'hide_context' => true,
                )

            ))
            ->end();
    }
}
