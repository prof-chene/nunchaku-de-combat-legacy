<?php

namespace NCBundle\Admin\Event;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;

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
            ->with('')
            ->add('exercises', ModelType::class, [
                'required' => false,
                'multiple' => true,
            ])
            ->end()
            ->end();
    }
}
