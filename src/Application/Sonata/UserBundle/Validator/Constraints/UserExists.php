<?php

namespace Application\Sonata\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class UserExists
 *
 * @package Application\Sonata\UserBundle\Validator\Constraints
 *
 * @Annotation
 */
class UserExists extends Constraint
{
    public $message = 'username_email.not_found';
}
