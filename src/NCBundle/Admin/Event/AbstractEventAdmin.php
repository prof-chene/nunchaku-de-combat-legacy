<?php

namespace NCBundle\Admin\Event;

use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class AbstractEventAdmin
 *
 * @package NCBundle\Admin\Event
 */
abstract class AbstractEventAdmin extends AbstractEditorialAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $isHorizontal = $this->getConfigurationPool()->getOption('form_type') == 'horizontal';
        $formMapper
            ->tab('tab_informations')
            ->with('group_event', array(
                'class' => 'col-md-8',
            ))
            ->add('title')
            ->add('thumbnail', 'sonata_media_type', array(
                'context' => 'event',
                'provider' => 'sonata.media.provider.image',
                'required' => false,
            ))
            ->add('content', 'sonata_formatter_type', array(
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field' => 'contentFormatter',
                'source_field' => 'rawContent',
                'source_field_options' => array(
                    'horizontal_input_wrapper_class' => $isHorizontal ? 'col-lg-12' : '',
                    'attr' => array('class' => $isHorizontal ? 'span10 col-sm-10 col-md-10' : '', 'rows' => 20),
                ),
                'ckeditor_context' => 'event',
                'target_field' => 'content',
                'listener' => true,
            ))
            ->end()
            ->with('group_scheduling', array(
                'class' => 'col-md-4',
            ))
            ->add('address')
            ->add('startDate', 'sonata_type_datetime_picker', array(
                'datepicker_use_button' => false,
                'dp_default_date' => new \DateTime(),
            ))
            ->add('endDate', 'sonata_type_datetime_picker', array(
                'datepicker_use_button' => false,
                'dp_default_date' => new \DateTime(),
            ))
            ->end()
            ->with('group_status', array(
                'class' => 'col-md-6',
            ))
            ->add('tags', 'sonata_type_model_autocomplete', array(
                'property' => 'name',
                'multiple' => 'true',
                'required' => false,
                'minimum_input_length' => 2,
                'quiet_millis' => 500,
            ))
            ->add('publicationDateStart', 'sonata_type_datetime_picker', array(
                'datepicker_use_button' => false,
                'dp_default_date' => new \DateTime(),
            ))
            ->add('enabled')
            ->end()
            ->end()
            ->tab('tab_participants')
            ->add('participants', 'sonata_type_collection', array(
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

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper
            ->add('startDate', 'doctrine_orm_datetime_range', array('field_type'=>'sonata_type_datetime_range_picker',))
            ->add('endDate', 'doctrine_orm_datetime_range', array('field_type'=>'sonata_type_datetime_range_picker',));
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper
            ->add('startDate')
            ->add('endDate');
    }
}
