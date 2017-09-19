<?php

namespace NCBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\FormatterBundle\Formatter\Pool as FormatterPool;

/**
 * Class AbstractEditorialAdmin
 *
 * @package NCBundle\Admin
 */
abstract class AbstractEditorialAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected  $translationDomain = 'admin';
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
    public function prePersist($editorial)
    {
        $editorial->setContent($this->formatterPool->transform($editorial->getContentFormatter(), $editorial->getRawContent()));
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($editorial)
    {
        $editorial->setContent($this->formatterPool->transform($editorial->getContentFormatter(), $editorial->getRawContent()));
    }

    /**
     * @param DatagridMapper $datagridMapper
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
     * @param ListMapper $listMapper
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
