<?php

namespace Application\Sonata\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class LoginType
 * @package Application\Sonata\Form
 */
class LoginType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'label'     => 'username',
                'required'  => true,
            ))
            ->add('password', 'password', array(
                'label'     => 'password',
                'required'  => true,
            ))
            ->add('remember_me', 'checkbox', array(
                'value'     => 'on',
                'label'     => 'remember_me',
                'required'  => false,
            ))
            ->add('submit', 'submit', array(
                'label'     => 'connection'
            ))
        ;
    }
}
