<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;

class UserAdmin extends \Sonata\UserBundle\Admin\Entity\UserAdmin
{
    /**
     * @param DatagridMapper $filterMapper
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        parent::configureDatagridFilters($filterMapper);
        $filterMapper
            ->add('lastname')
            ->add('firstname');
    }
}
