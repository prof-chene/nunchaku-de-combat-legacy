<?php

namespace NCBundle\Admin\Event;

use Application\Sonata\ClassificationBundle\Entity\Context;
use NCBundle\Admin\AbstractEditorialAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\Form\Type\CollectionType;
use Sonata\Form\Type\DateTimePickerType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Sonata\MediaBundle\Form\Type\MediaType;

/**
 * Class AbstractEventAdmin
 */
abstract class AbstractEventAdmin extends AbstractEditorialAdmin
{
    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        parent::prePersist($object);
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getParticipants() as $participant) {
            $participant->setEvent($object);
            $participant->setRegistrant($this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        parent::preUpdate($object);
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($object->getParticipants() as $participant) {
            if (!$this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->contains($participant)) {
                $participant->setEvent($object);
                $participant->setRegistrant($this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser());
            }
        }
    }

    /**
     * {@inheritdoc}
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
            ->add('image', MediaType::class, array(
                'context'  => Context::DEFAULT_CONTEXT,
                'provider' => 'sonata.media.provider.image',
                'required' => false,
            ))
            ->add('content', FormatterType::class, array(
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
            ->add('startDate', DateTimePickerType::class, array(
                'datepicker_use_button' => false,
                'dp_default_date' => new \DateTime(),
            ))
            ->add('endDate', DateTimePickerType::class, array(
                'datepicker_use_button' => false,
                'dp_default_date' => new \DateTime(),
            ))
            ->end()
            ->with('group_status', array(
                'class' => 'col-md-12',
            ))
            ->add('tags', ModelType::class, [
                'multiple' => 'true',
                'required' => false,
            ])
            ->add('publicationDateStart', DateTimePickerType::class, array(
                'datepicker_use_button' => false,
                'dp_default_date' => new \DateTime(),
            ))
            ->add('enabled')
            ->end()
            ->end()
            ->tab('tab_participants')
            ->with('')
            ->add('participants', CollectionType::class, array(
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
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id');
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper
            ->add('startDate', 'doctrine_orm_datetime_range', array('field_type'=>'sonata_type_datetime_range_picker',))
            ->add('endDate', 'doctrine_orm_datetime_range', array('field_type'=>'sonata_type_datetime_range_picker',));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id');
        parent::configureListFields($listMapper);
        $listMapper
            ->add('startDate')
            ->add('endDate');
    }
}
