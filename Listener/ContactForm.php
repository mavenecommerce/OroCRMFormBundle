<?php

namespace Maven\Bundle\FromBundle\Listener;

use Oro\Bundle\EmbeddedFormBundle\Event\EmbeddedFormSubmitAfterEvent;
use Oro\Bundle\EmbeddedFormBundle\Event\EmbeddedFormSubmitBeforeEvent;

class ContactForm {

    public function onOroembeddedformFormsubmitAfter(EmbeddedFormSubmitAfterEvent $event) {

        /** @var \Oro\Bundle\EmbeddedFormBundle\Entity\EmbeddedForm $form */
        $formEntity = $event->getFormEntity();

        return;
        //$fManager = $formEntity->get('oro_embedded_form.manager');
//        var_dump(get_class($formEntity));
//        exit;

        /** @var \OroCRM\Bundle\ContactUsBundle\Entity\ContactRequest */
        $data = $event->getData();

        /** @var \Symfony\Component\Form\Form $form */
        //$form = $event->getForm();


        $form->get('emailAddress')->setData($form->getData('phone_or_email'));

        $fullName = $form->get('fullName')->getData();
        $nameData = explode(' ', $fullName);
        $firstName = array_pop($nameData);
        $lastName = implode(' ', $nameData);

        $form->get('emailAddress')->setData($form->getData('phone_or_email'));

        $form->get('firstName')->setData($firstName);
        $form->get('lastName')->setData($lastName);

        $data->setLastName('safsdfsdf');


    }

}