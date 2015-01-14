<?php
/**
 *
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Framework\Interception;

/**
 * Class TwoPluginTest
 */
class TwoPluginTest extends GeneralTest
{
    public function setUp()
    {
        $this->setUpInterceptionConfig(
            [
                'Magento\Framework\Interception\Fixture\Intercepted' => [
                    'plugins' => [
                        'first'     => [
                            'instance'  => 'Magento\Framework\Interception\Fixture\Intercepted\FirstPlugin',
                            'sortOrder' => 10,
                        ], 'second' => [
                            'instance'  => 'Magento\Framework\Interception\Fixture\Intercepted\Plugin',
                            'sortOrder' => 20,
                        ]
                    ],
                ]
            ]
        );
    }

    public function testPluginBeforeWins()
    {
        $subject = $this->_objectManager->create('Magento\Framework\Interception\Fixture\Intercepted');
        $this->assertEquals('<X><P:bX/></X>', $subject->X('test'));
    }

    public function testPluginAroundWins()
    {
        $subject = $this->_objectManager->create('Magento\Framework\Interception\Fixture\Intercepted');
        $this->assertEquals('<F:Y>test<F:Y/>', $subject->Y('test'));
    }

    public function testPluginAfterWins()
    {
        $subject = $this->_objectManager->create('Magento\Framework\Interception\Fixture\Intercepted');
        $this->assertEquals('<P:aZ/>', $subject->Z('test'));
    }

    public function testPluginBeforeAroundWins()
    {
        $subject = $this->_objectManager->create('Magento\Framework\Interception\Fixture\Intercepted');
        $this->assertEquals('<F:V><F:bV/><F:V/>', $subject->V('test'));
    }

    public function testPluginBeforeAroundAfterWins()
    {
        $subject = $this->_objectManager->create('Magento\Framework\Interception\Fixture\Intercepted');
        $this->assertEquals('<F:aW/>', $subject->W('test'));
    }
}
