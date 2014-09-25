<?php
namespace Application\Test;

class UnitTestCase extends \Phalcon\Test\UnitTestCase
{
    /**
     * @var \Phalcon\DiInterface
     */
    protected $di;
    /**
     * @var bool
     */
    protected $_loaded = false;

    public function setUp(\Phalcon\DiInterface $di = NULL, \Phalcon\Config $config = NULL)
    {
        // Load any additional services that might be required during testing
        $this->di = \Phalcon\DI::getDefault();

//        $stub = $this->getMockBuilder('\Phalcon\Session\Bag')
//            ->setConstructorArgs(['user'])
//            ->getMock();
//
//        $stub->expects($this->at(0)) // Always called first by: new Phalcon\Session\Bag()
//            ->method('setDI')
//            ->will($this->returnCallback(function($di) {
//                $this->di = $di;
//            }));
//
//        $stub->expects($this->at(1)) // First, we're checking if session key is set
//            ->method('__isset')
//            ->will($this->returnCallback(function($sessionKey) {
//                // Yes, always set
//                return true;
//            }));
//
////        $stub->expects($this->at(2)) // Then, we're fetching it
////            ->method('__get')
////            ->will($this->returnValueMap($map));

//        $this->di->setShared('session', $stub);

        // get any DI components here. If you have a config, be sure to pass it to the parent
        parent::setUp($this->di);

        $this->_loaded = true;
    }

    /**
     * Check if the test case is setup properly
     * @throws \PHPUnit_Framework_IncompleteTestError;
     */
    public function __destruct()
    {
        if (!$this->_loaded) {
            throw new \PHPUnit_Framework_IncompleteTestError('Please run parent::setUp().');
        }
    }

    protected function tearDown()
    {

    }
}