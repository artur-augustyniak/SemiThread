<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Artur Augustyniak
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Aaugustyniak\Tests\SemiThread;

use Aaugustyniak\SemiThread\Cloneable;
use \Mockery as m;
use Aaugustyniak\SemiThread\ConfinedEnvelope;

/**
 * @author Artur Augustyniak <artur@aaugustyniak.pl>
 */
class ConfinedEnvelopeTest extends BaseTest
{

    const CLONEABLE_IFACE = 'Aaugustyniak\SemiThread\Cloneable';
    const CLONE_INDICATOR = '#!CLONE';

    public function testReturnInstanceOfCloneable()
    {
        $inputCloneable = $this->createCloneableMock();
        $envelope = new ConfinedEnvelope($inputCloneable);
        $outputCloneable = $envelope->popPayloadOnce();
        $this->assertInstanceOf(self::CLONEABLE_IFACE, $outputCloneable);
    }

    /**
     * @expectedException Aaugustyniak\SemiThread\Exception\ConfineViolation
     */
    public function testCantPopMoreThenOnce()
    {
        $inputCloneable = $this->createCloneableMock();
        $envelope = new ConfinedEnvelope($inputCloneable);
        $envelope->popPayloadOnce();
        $envelope->popPayloadOnce();
    }

    public function testPayloadPopReturnsClone()
    {
        $inputCloneable = $this->createCloneableMock();
        $envelope = new ConfinedEnvelope($inputCloneable);
        $output = $envelope->popPayloadOnce();
        $this->assertEquals(self::CLONE_INDICATOR, $output->getSelfClone());
    }

    /**
     *
     * @return Cloneable
     */
    private function createCloneableMock()
    {
        $methodIndicatingMock = array('getSelfClone' => self::CLONE_INDICATOR);
        $mockClone = m::mock(self::CLONEABLE_IFACE, $methodIndicatingMock);
        $method = array('getSelfClone' => $mockClone);
        $mock = m::mock(self::CLONEABLE_IFACE, $method);
        return $mock;
    }

}
