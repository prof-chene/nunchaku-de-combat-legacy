<?php

namespace NCBundle\Admin\Event;

use NCBundle\Entity\Event\Trial;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Sonata\FormatterBundle\Formatter\Pool as FormatterPool;

/**
 * Class TrialAdmin
 */
class TrialAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected  $translationDomain = 'admin';
    /**
     * @var FormatterPool
     */
    protected $formatterPool;
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_trial';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'trial';

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
        $object->setRules($this->formatterPool->transform($object->getRulesFormatter(), $object->getRawRules()));
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        $object->setRules($this->formatterPool->transform($object->getRulesFormatter(), $object->getRawRules()));
    }

    /**
     * @param Trial $subject
     */
    public function setSubject($subject)
    {
        $subject->setLocale($this->getRequest()->getLocale());
        parent::setSubject($subject);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $isHorizontal = $this->getConfigurationPool()->getOption('form_type') == 'horizontal';
        $formMapper
            ->add('name', 'text')
            ->add('rules', FormatterType::class, array(
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field' => 'rulesFormatter',
                'source_field' => 'rawRules',
                'source_field_options' => array(
                    'horizontal_input_wrapper_class' => $isHorizontal ? 'col-lg-12' : '',
                    'attr' => array('class' => $isHorizontal ? 'span10 col-sm-10 col-md-10' : '', 'rows' => 20),
                ),
                'ckeditor_context' => 'event',
                'target_field' => 'rules',
                'listener' => true,
            ));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('competition');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('competition');
    }
}
