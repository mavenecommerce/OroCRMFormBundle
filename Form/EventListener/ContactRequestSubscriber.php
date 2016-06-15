<?php

namespace Maven\Bundle\FormBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use OroCRM\Bundle\ContactUsBundle\Entity\ContactRequest;

/**
 * @package Maven\Bundle\FormBundle\Form\EventListener
 */
class ContactRequestSubscriber implements EventSubscriberInterface
{
    const ROUTE = 'orocrm_contactus_request_create';

    /**
     * @var string
     */
    protected $route;

    /**
     * @param string $route
     */
    public function __construct($route)
    {
        $this->route = $route;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SUBMIT => 'preSubmit',
            FormEvents::PRE_SET_DATA => 'preSetData',
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();

        if ($this->isAdminRoute()) {
            $form->add('lastName');
            $form->add('firstName');
            $form->add('emailAddress');
            $form->add('phone');
        } else {
            $form->add('lastName', 'hidden');
            $form->add('firstName', 'hidden');
            $form->add('emailAddress', 'hidden');
            $form->add('phone', 'hidden');
            $form->add('preferredContactMethod', 'hidden');
        }
    }
    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();

        if (!$data || !$data['fullName'] || !$data['fullName'] ||$this->isAdminRoute()) {
            return;
        }

        $fullName = $this->sliceFullName($data['fullName']);
        $data['firstName'] = $fullName['firstName'];
        $data['lastName'] = $fullName['lastName'];

        $data['phone'] =  $data['phoneOrEmail'];
        $data['preferredContactMethod'] = ContactRequest::CONTACT_METHOD_PHONE;

        if ($this->checkEmail($data['phoneOrEmail'])) {
            $data['preferredContactMethod'] = ContactRequest::CONTACT_METHOD_EMAIL;
            $data['emailAddress'] = $data['phoneOrEmail'];
            $data['phone'] = '';
        }

        $event->setData($data);
    }

    /**
     * @param $value
     *
     * @return array
     */
    private function sliceFullName($value)
    {
        $pattern = "/[\s]+/";
        $matches = preg_split($pattern, $value);

        return [
            'firstName' => $matches[0],
            'lastName'  => $matches[1],
        ];
    }

    /**
     * @param $value
     *
     * @return bool
     */
    private function checkEmail($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isAdminRoute()
    {
        return $this->route === self::ROUTE;
    }
}
