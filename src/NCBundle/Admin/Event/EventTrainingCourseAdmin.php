<?php

namespace NCBundle\Admin\Event;

use NCBundle\Entity\Event\Participant;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class EventTrainingCourseAdmin
 *
 * @package NCBundle\Admin\Event
 */
class EventTrainingCourseAdmin extends Admin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_training_course';
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
            ->add('description', 'textarea')
            ->add('startDate', 'date')
            ->add('endDate', 'date')
            ->add('address', 'textarea')
            ->add('participants',
                'sonata_type_collection',
                array(
                    'type_options' => array(
                        'data_class' => 'NCBundle\Entity\Event\Participant',
                    )
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                )
            )
            ->add('trainers',
                'sonata_type_collection',
                array(
                    'type_options' => array(
                        'data_class' => 'NCBundle\Entity\Event\Participant',
                    )
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                )
            )
            ->add('exercises',
                'sonata_type_collection',
                array(
                    'type_options' => array(
                        'data_class' => 'NCBundle\Entity\Technique\Exercise',
                    )
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                )
            )
            ->add('medias',
                'sonata_type_collection',
                array(
                    'type' => 'sonata_type_model_list',
                    'type_options' => array(
                        'sonata_field_description' => array(
                            'link_parameters' => array(
                                'context' => 'event',
                                'hide_context' => true,
                            )
                        )
                    ),
                    'required' => false,
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
            ->add('description')
            ->add('startDate')
            ->add('endDate')
            ->add('address')
            ->add('participants.lastname')
            ->add('participants.firstname')
            ->add('trainers.lastname')
            ->add('trainers.firstname')
            ->add('exercises.name')
            ->add('medias.name');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('description')
            ->add('startDate')
            ->add('endDate')
            ->add('address')
            ->add('participants', null, array(
                'associated_property' => function (Participant $participant) {
                    return $participant->getLastname() . ' ' . $participant->getFirstname();
                },
            ))
            ->add('trainers', null, array(
                'associated_property' => function (Participant $trainer) {
                    return $trainer->getLastname() . ' ' . $trainer->getFirstname();
                },
            ))
            ->add('exercises', null, array(
                'associated_property' => 'name',
            ))
            ->add('medias', null, array(
                'associated_property' => 'name',
            ));
    }
}
