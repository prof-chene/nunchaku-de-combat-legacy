<?php

namespace NCBundle\Admin\Event;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;

/**
 * Class TrainingCourseAdmin
 */
class TrainingCourseAdmin extends AbstractEventAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_training_course';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'trainingCourse';

    /**
     * {@inheritdoc}
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
