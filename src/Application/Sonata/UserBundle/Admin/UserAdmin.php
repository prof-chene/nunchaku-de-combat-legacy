<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;

class UserAdmin extends \Sonata\UserBundle\Admin\Entity\UserAdmin
{
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
