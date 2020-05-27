<?php

namespace NCBundle\Admin\Technique;

use NCBundle\Entity\Technique\TechniqueExecution;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class TechniqueExecutionAdmin
 */
class TechniqueExecutionAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected  $translationDomain = 'admin';
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_technique_execution';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'technique/execution';

    /**
     * @param TechniqueExecution $subject
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
        $formMapper
            ->add('technique', 'sonata_type_model')
            ->add('detail', 'textarea');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('detail')
            ->add('technique.title')
            ->add('exercise.title');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('technique', null, array(
                'associated_property' => 'title',
            ))
            ->add('detail', 'textarea')
            ->add('exercise', null, array(
                'associated_property' => 'title',
            ));
    }
}
