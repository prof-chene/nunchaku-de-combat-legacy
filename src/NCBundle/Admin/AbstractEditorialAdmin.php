<?php

namespace NCBundle\Admin;

use Application\Sonata\ClassificationBundle\Entity\Context;
use NCBundle\Entity\AbstractEditorial;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\Form\Type\DateTimePickerType;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Sonata\FormatterBundle\Formatter\Pool as FormatterPool;
use Sonata\MediaBundle\Form\Type\MediaType;

/**
 * Class AbstractEditorialAdmin
 */
abstract class AbstractEditorialAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $translationDomain = 'admin';
    /**
     * @var FormatterPool
     */
    protected $formatterPool;

    /**
     * @param FormatterPool $formatterPool
     */
    public function setPoolFormatter(FormatterPool $formatterPool)
    {
        $this->formatterPool = $formatterPool;
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $object->setContent($this->formatterPool->transform($object->getContentFormatter(), $object->getRawContent()));
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        $object->setContent($this->formatterPool->transform($object->getContentFormatter(), $object->getRawContent()));
    }

    /**
     * @param AbstractEditorial $subject
     */
    public function setSubject($subject)
    {
        $subject->setLocale($this->getRequest()->getLocale());
        parent::setSubject($subject);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $isHorizontal = $this->getConfigurationPool()->getOption('form_type') == 'horizontal';
        $formMapper
            ->with('group_content', array(
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
                'ckeditor_context' => 'content',
                'target_field' => 'content',
                'listener' => true,
            ))
            ->end()
            ->with('group_status', array(
                'class' => 'col-md-4',
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
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('publicationDateStart', 'doctrine_orm_datetime_range', array('field_type'=>'sonata_type_datetime_range_picker',))
            ->add('tags', null, array(
                'field_options' => array('expanded' => true, 'multiple' => true),
            ))
            ->add('enabled');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('publicationDateStart')
            ->add('tags')
            ->add('enabled');
    }
}
