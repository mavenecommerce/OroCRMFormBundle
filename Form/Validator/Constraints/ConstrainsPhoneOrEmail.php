<?php

namespace Maven\Bundle\FormBundle\Form\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @package Maven\Bundle\FormBundle\Form\Validator\Constraints
 */
class ConstrainsPhoneOrEmail extends Constraint
{
    /**
     * @var string
     */
    public $message = 'This field can only contain phone numbers or email.';
}
