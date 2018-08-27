<?php

namespace Application\Sonata\UserBundle\Form\Type;

use Application\Sonata\UserBundle\Validator\Constraints\UserExists;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ResetPasswordRequestType
 */
class ResetPasswordRequestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username_email', 'text', array(
                'label'     => 'username_email',
                'required'  => true,
                'constraints' => new UserExists(),
            ))
            ->add('submit', 'submit', array(
                'label'     => 'reset_password.request'
            ))
        ;
    }
}
