<?php

/**
 * Security service test
 *
 * Class SecurityTest
 */
class SecurityTest extends \Application\Test\UnitTestCase
{
    public function testGetWorkFactor()
    {
        $this->assertEquals($this->di->getConfig()->security->rounds, $this->di->getSecurity()->getWorkFactor());
    }
}