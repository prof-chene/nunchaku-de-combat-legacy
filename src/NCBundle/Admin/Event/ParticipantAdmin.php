<?php

namespace NCBundle\Admin\Event;

use Application\Sonata\UserBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class ParticipantAdmin
 *
 * @package NCBundle\Admin\Event
 */
class ParticipantAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected  $translationDomain = 'admin';
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_participant';
    /**
     * @var string
     */
    protected $baseRoutePattern = 'participant';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('lastname')
            ->add('firstname')
            ->add('phone')
            ->add('dateOfBirth', 'sonata_type_date_picker', array(
                'datepicker_use_button' => false,
                'dp_max_date' => new \DateTime(),
            ))
            ->add('gender', 'choice', array(
                'choices' => array(
                    'male' => 'm',
                    'female' => 'f',
                )
            ))
            ->add('address', 'textarea')
            ->add('user', 'sonata_type_model_autocomplete', array(
                'placeholder' => 'choose_user',
                'class' => 'Application\Sonata\UserBundle\Entity\User',
                'property' => array('firstname', 'lastname', 'username'),
                'required' => false,
                'minimum_input_length' => 2,
                'quiet_millis' => 500,
                'to_string_callback' => function($entity, $property) {
                    return $entity->getFullname().' (@'.$entity->getUsername().')';
                },
            ))
        ;

        // Stuff related to the parent Event
        if ($this->hasParentFieldDescription()) {

            // Conditionnal field based on the Event type
            switch ($this->getParentFieldDescription()->getAdmin()->getCode()) {
                case 'admin.show':
                    $formMapper->add('host');
                    break;
                case 'admin.trainingCourse':
                    $formMapper->add('trainer');
                    break;
                case 'admin.competition':
                    $formMapper->add('referee');
                    break;
            }
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('lastname')
            ->add('firstname')
            ->add('phone')
            ->add('dateOfBirth')
            ->add('gender')
            ->add('address')
            ->add('user.lastname')
            ->add('user.firstname')
            ->add('event.title');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('lastname')
            ->add('firstname')
            ->add('phone')
            ->add('dateOfBirth')
            ->add('gender')
            ->add('address')
            ->add('user', null, array(
                'associated_property' => function (User $user) {
                    return $user->getFullname();
                },
            ))
            ->add('event', null, array(
                'associated_property' => 'title',
            ));
    }
}
