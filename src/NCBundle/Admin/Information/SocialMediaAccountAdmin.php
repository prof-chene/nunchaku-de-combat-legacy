<?php

namespace NCBundle\Admin\Information;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class ScheduledLessonAdmin
 */
class SocialMediaAccountAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $translationDomain = 'admin';
    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_social_media_account';
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'social_media_account';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('socialMedia', ChoiceType::class, [
                'choices' => [
                    'facebook'   => 'facebook',
                    'google'     => 'google',
                    'instagram'  => 'instagram',
                    'pinterest'  => 'pinterest',
                    'reddit'     => 'reddit',
                    'soundcloud' => 'soundcloud',
                    'tumblr'     => 'tumblr',
                    'twitter'    => 'twitter',
                ],
            ])
            ->add('url');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('socialMedia')
            ->add('url')
            ->add('club.name');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('socialMedia')
            ->addIdentifier('url')
            ->add('club', null, [
                'associated_property' => 'name',
            ]);
    }
}
