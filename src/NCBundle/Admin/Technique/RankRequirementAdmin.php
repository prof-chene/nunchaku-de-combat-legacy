<?php

namespace NCBundle\Admin\Technique;

use NCBundle\Entity\Technique\RankRequirement;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;

class RankRequirementAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected  $translationDomain = 'admin';
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_rank_requirement';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'rank/requirement';

    /**
     * @param RankRequirement $subject
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
            ->add('rank')
            ->add('exercise', ModelType::class, [
                'class'    => 'NCBundle\Entity\Technique\Exercise',
                'property' => 'title',
                'required' => true,
            ])
            ->add('detail', 'textarea')
            ->add('points', 'integer');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('rank')
            ->add('exercise')
            ->add('detail');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('rank')
            ->addIdentifier('exercise')
            ->add('detail', 'textarea');
    }
}
