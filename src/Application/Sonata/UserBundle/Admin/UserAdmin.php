<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends \Sonata\UserBundle\Admin\Entity\UserAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        parent::configureFormFields($formMapper);
        $formMapper
            ->tab('tab_styles')
            ->add('ranks')
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper): void
    {
        parent::configureDatagridFilters($filterMapper);
        $filterMapper
            ->add('lastname')
            ->add('firstname');
    }
}
