<?php

namespace Maven\Bundle\FormBundle\Tests\Unit\Form\Type;

use Symfony\Component\HttpFoundation\RequestStack;

use Oro\Bundle\EmbeddedFormBundle\Form\Type\EmbeddedFormInterface;

use Maven\Bundle\FormBundle\Form\Type\ContactRequestType;

/**
 * @package Maven\Bundle\FormBundle\Tests\Unit\Form\Type
 */
class ContactRequestTypeTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContactRequestType */
    protected $formType;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->formType = new ContactRequestType(new RequestStack());
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->formType);
    }

    /**
     * {@inheritdoc}
     */
    public function testHasName()
    {
        $this->assertEquals('maven_form_contact_request', $this->formType->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function testParent()
    {
        $this->assertEquals('form', $this->formType->getParent());
    }

    /**
     * {@inheritdoc}
     */
    public function testImplementEmbeddedFormInterface()
    {
        $this->assertTrue($this->formType instanceof EmbeddedFormInterface);

        $this->assertNotEmpty($this->formType->getDefaultCss());
        $this->assertInternalType('string', $this->formType->getDefaultCss());

        $this->assertNotEmpty($this->formType->getDefaultSuccessMessage());
        $this->assertInternalType('string', $this->formType->getDefaultSuccessMessage());
    }

    /**
     * {@inheritdoc}
     */
    public function testBuildForm()
    {
        $builder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')
            ->disableOriginalConstructor()->getMock();

        $fields = [];
        $builder->expects($this->exactly(5))
            ->method('add')
            ->will(
                $this->returnCallback(
                    function ($fieldName, $fieldType) use (&$fields) {
                        $fields[$fieldName] = $fieldType;

                        return new \PHPUnit_Framework_MockObject_Stub_ReturnSelf();
                    }
                )
            );

        $this->formType->buildForm($builder, ['dataChannelField' => true]);

        $this->assertSame(
            [
                'dataChannel'            => 'orocrm_channel_select_type',
                'fullName'              => 'text',
                'phoneOrEmail'           => 'text',
                'comment'                => 'textarea',
                'submit'                 => 'submit',
            ],
            $fields
        );
    }
}
