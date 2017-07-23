<?php

namespace NCBundle\Admin\Event;

use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class TrainingCourseAdmin
 *
 * @package NCBundle\Admin\Event
 */
class TrainingCourseAdmin extends AbstractEventAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_training_course';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'trainingCourse';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        $formMapper
            ->tab('tab_schedule')
            ->add('exercises', 'sonata_type_collection', array(
                'type_options' => array(
                    'delete' => false,
                ),
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
