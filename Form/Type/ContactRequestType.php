<?php

namespace Maven\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

use Oro\Bundle\EmbeddedFormBundle\Form\Type\EmbeddedFormInterface;

use OroCRM\Bundle\ContactUsBundle\Entity\ContactRequest;

use Maven\Bundle\FormBundle\Form\EventListener\ContactRequestSubscriber;
use Maven\Bundle\FormBundle\Form\Validator\Constraints\ConstrainsPhoneOrEmail;

/**
 * @package Maven\Bundle\FormBundle\Form\Type
 */
class ContactRequestType extends AbstractType implements EmbeddedFormInterface
{
    /**
     * @var RequestStack
     */
    protected $request;

    /**
     * @param RequestStack|null $request
     */
    public function __construct(RequestStack $request = null)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'maven_form_contact_request';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['dataChannelField']) {
            $builder->add(
                'dataChannel',
                'orocrm_channel_select_type',
                [
                    'required' => true,
                    'label'    => 'orocrm.contactus.contactrequest.data_channel.label',
                    'entities' => [
                        'OroCRM\\Bundle\\ContactUsBundle\\Entity\\ContactRequest',
                    ],
                ]
            );
        }

        $builder->add(
            'fullName',
            'text',
            [
                'mapped'  => false,
                'label'   => false,
                'constraints' => [
                    new NotBlank(),
                ],
                'attr'    => [
                    'placeholder' => 'maven.form.embedded_form.full_name.label',
                ],
            ]
        );
        $builder->add(
            'phoneOrEmail',
            'text',
            [
                'required' => false,
                'mapped'   => false,
                'label'    => false,
                'constraints' => [
                    new NotBlank(),
                    new ConstrainsPhoneOrEmail(),
                ],
                'attr'     => [
                    'placeholder' => 'maven.form.embedded_form.phoneOrName',
                ],
            ]
        );
        $builder->add(
            'comment',
            'textarea',
            [
                'label' => false,
                'attr'  => [
                    'placeholder' => 'maven.form.embedded_form.comment.label',
                ],
            ]
        );
        $builder->add('submit', 'submit');

        if (!is_null($this->request->getMasterRequest())) {
            $builder->addEventSubscriber(
                new ContactRequestSubscriber(
                    $this->request->getMasterRequest()
                        ->get('_route')
                )
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'OroCRM\Bundle\ContactUsBundle\Entity\ContactRequest',
                'dataChannelField' => false,
            ]
        );
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function getDefaultCss()
    {
        return <<<CSS
ul, li {
     list-style: none;
     overflow: hidden;
     clear: both;
     margin: 0;
 }
 textarea,
 input[type="text"],
 input[type="password"],
 input[type="datetime"],
 input[type="datetime-local"],
 input[type="date"],
 input[type="month"],
 input[type="time"],
 input[type="week"],
 input[type="number"],
 input[type="email"],
 input[type="url"],
 input[type="search"],
 input[type="tel"],
 input[type="color"],
 .uneditable-input {
    background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s;
    box-sizing: content-box;
    -moz-box-sizing: content-box;
    -webkit-box-sizing: content-box;
}
select,
textarea,
input[type="text"],
input[type="password"],
input[type="datetime"],
input[type="datetime-local"],
input[type="date"],
input[type="month"],
input[type="time"],
input[type="week"],
input[type="number"],
input[type="email"],
input[type="url"],
input[type="search"],
input[type="tel"],
input[type="color"],
.uneditable-input {
    border-radius: 3px;
    color: #555555;
    display: inline-block;
    font-size: 13px;
    height: 20px;
    line-height: 20px;
    margin-bottom: 10px;
    padding: 4px 6px;
    vertical-align: middle;
}
textarea{
    resize: vertical;
    height: 150px;
}
select {
    height: 26px;
    line-height: 26px;
    border: 1px solid #ccc;
    width: 262px;
}
.page-title {
    width: 100%;
    overflow: hidden;
    border-bottom: 1px solid #ccc;
    margin: 0 0 25px;
}
 .page-title h1{
     margin: 0;
     font-size: 20px;
     color: #0a263c;
 }

.fieldset {
    border: 1px solid #bbafa0;
    background: #fbfaf6;
    padding: 22px 25px 12px 33px;
    margin: 28px 0;
    font-size: 13px;
    line-height: 16px;
    font-family: 'Helvetica Neue',Arial,Helvetica,sans-serif;
}

.fieldset .legend {
    float: left;
    font-size: 13px;
    line-height: 20px;
    border: 1px solid #f19900;
    background: #f9f3e3;
    color: #e76200;
    margin: -33px 0 0 -10px;
    padding: 0 8px;
    position: relative;
    font-family: 'Helvetica Neue',Arial,Helvetica,sans-serif;
    font-weight: bold;
}
.form-list{
    padding: 0;
}
.form-list .control-group {
    margin-bottom: 0px;
}
.form-list li{
    margin: 0 0 3px;
}
.form-list label {
    float: left;
    color: #666;
    font-weight: bold;
    position: relative;
    z-index: 0;
    margin-bottom: 0;
}
.form-list .controls {
    display: block;
    clear: both;
    width: 260px;
}

.form-list input[type="text"],
.form-list input[type="email"] {
    width: 254px;
    padding: 3px;
    margin-bottom: 3px;

}

.form-list li.wide .controls {
    width: 550px;
}

.form-list li.wide textarea {
    width: 100%;
    padding: 3px;
    margin-bottom: 3px;
}

.buttons-set {
    clear: both;
    margin: 4em 0 0;
    padding: 8px 10px 0;
    border-top: 1px solid #e4e4e4;
    text-align: right;
}

.buttons-set p.required {
    margin: 0 0 10px;
    font-size: 11px;
    text-align: right;
    color: #EB340A;
    font: 11px/14px Arial, Helvetica, sans-serif;
}

.buttons-set button {
    float: right;
    margin-left: 5px;
    display: block;
    height: 19px;
    border: 1px solid #de5400;
    background: #f18200;
    padding: 0 8px;
    font: bold 12px/19px Arial, Helvetica, sans-serif;
    text-align: center;
    white-space: nowrap;
    color: #fff;
    box-sizing: content-box;
}
.page-title h1{
    font: 20px/24px Arial, Helvetica, sans-serif;
}
span.validation-failed {
    color: #c81717;
    display: block;
    margin: 3px 0 5px 0px;
    font: bold 1em/1.1em 'Helvetica Neue',Arial,Helvetica,sans-serif;
}
label em {
    color: #eb340a;
    font-size: 16px;
}
CSS;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultSuccessMessage()
    {
        return '<p>Form has been submitted successfully</p>{back_link}';
    }
}
