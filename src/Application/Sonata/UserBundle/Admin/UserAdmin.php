<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;

class UserAdmin extends \Sonata\UserBundle\Admin\Entity\UserAdmin
{
    /**
     * {@inheritdoc}
     */
    public function preUpdate($user): void
    {
        parent::preUpdate($user);
        // https://stackoverflow.com/questions/21420380/entitys-id-of-parent-is-not-saved-in-a-onetomany-relationship-in-sonataadmin#answer-21576616
        foreach($user->getRanks() as $rankHolder) {
            if (!$this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager')->contains($rankHolder)) {
                $rankHolder->setHolder($user);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        parent::configureFormFields($formMapper);
        /* We cannot persist the User AND its Ranks at once because the RankHolder entity's identity is composed by its
           User and Rank, thus we would have to flush the User first to generate its identity, then set its RankHolders
           and flush again.
           => The User's ranks are not available in the "create" route's form.
        */
        if (!$this->isCurrentRoute('create')) {
            $formMapper
                ->tab('tab_styles', ['translation_domain' => 'admin'])
                ->with('group_ranks', ['translation_domain' => 'admin'])
                ->add('ranks',
                    CollectionType::class,
                    [
                        'required' => true,
                        'label'    => 'Ranks',
                    ],
                    [
                        'edit'            => 'inline',
                        'inline'          => 'table',
                        'link_parameters' => ['hide_context' => true,],
                    ]
                )
                ->end();
        }
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
