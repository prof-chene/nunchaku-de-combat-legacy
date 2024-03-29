<?php

namespace NCBundle\Admin;

use NCBundle\Entity\HighlightedContent;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class HighlightedContentAdmin
 */
class HighlightedContentAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $translationDomain = 'admin';
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_highlighted_content';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'highlighted-content';

    /**
     * @param HighlightedContent $subject
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
        $formMapper
            ->add('position')
            ->add('title')
            ->add('abstract')
            ->add('content')
            ;
    }
    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('position')
            ->add('title')
            ->add('abstract');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('position')
            ->add('abstract');
    }
}
