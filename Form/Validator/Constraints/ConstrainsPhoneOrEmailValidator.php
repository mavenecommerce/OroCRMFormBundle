<?php

namespace Maven\Bundle\FormBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @package Maven\Bundle\FormBundle\Form\Validator\Constraints
 */
class ConstrainsPhoneOrEmailValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL) && !is_numeric($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
