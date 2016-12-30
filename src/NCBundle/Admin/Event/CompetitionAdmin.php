<?php

namespace NCBundle\Admin\Event;

use NCBundle\Entity\Event\Participant;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class CompetitionAdmin
 *
 * @package NCBundle\Admin\Event
 */
class CompetitionAdmin extends Admin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_competition';
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
            ->add('trials',
                'sonata_type_collection',
                array(
                    'type_options' => array(
                        'data_class' => 'NCBundle\Entity\Event\Trial',
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
            ->add('trials.name')
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
            ->add('trials', null, array(
                'associated_property' => 'name',
            ))
            ->add('medias', null, array(
                'associated_property' => 'name',
            ));
    }
}
