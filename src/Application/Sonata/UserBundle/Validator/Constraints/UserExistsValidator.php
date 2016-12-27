<?php

namespace Application\Sonata\UserBundle\Validator\Constraints;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class UserExistsValidator
 *
 * @package Application\Sonata\UserBundle\Validator\Constraints
 */
class UserExistsValidator extends ConstraintValidator
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * UserExistsValidator constructor.
     *
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param mixed $value
     *
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$this->userManager->findUserByUsernameOrEmail($value) instanceof UserInterface) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }

}
