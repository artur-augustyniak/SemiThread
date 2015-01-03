<?php

namespace Aaugustyniak\Tests\SemiThread;

use \Mockery as m;
use \PHPUnit_Framework_TestCase as TestCase;
use Aaugustyniak\SemiThread\ConfinedEnvelope;

/**
 * Description of ConfinedEnvelopeTest
 *
 * @author aaugustyniak
 */
class ConfinedEnvelopeTest extends TestCase {

    const CLONEABLE_IFACE = 'Aaugustyniak\SemiThread\Cloneable';
    const CLONE_INDICATOR = '#!CLONE';

    public function testReturnInstanceOfCloneable() {
        $inputCloneable = $this->createCloneableMock();
        $envelope = new ConfinedEnvelope($inputCloneable);
        $outputCloneable = $envelope->popPayloadOnce();
        $this->assertInstanceOf(self::CLONEABLE_IFACE, $outputCloneable);
    }

    /**
     * @expectedException Aaugustyniak\SemiThread\ConfineViolation
     */
    public function testCantPopMoreThenOnce() {
        $inputCloneable = $this->createCloneableMock();
        $envelope = new ConfinedEnvelope($inputCloneable);
        $envelope->popPayloadOnce();
        $envelope->popPayloadOnce();
    }

    public function testPayloadPopReturnsClone() {
        $inputCloneable = $this->createCloneableMock();
        $envelope = new ConfinedEnvelope($inputCloneable);
        $output = $envelope->popPayloadOnce();
        $this->assertEquals(self::CLONE_INDICATOR, $output->getSelfClone());
    }

    /**
     * 
     * @return Cloneable
     */
    private function createCloneableMock() {
        $methodIndocatingMock = array('getSelfClone' => self::CLONE_INDICATOR);
        $mockClone = m::mock(self::CLONEABLE_IFACE, $methodIndocatingMock);
        $method = array('getSelfClone' => $mockClone);
        $mock = m::mock(self::CLONEABLE_IFACE, $method);
        return $mock;
    }

}
