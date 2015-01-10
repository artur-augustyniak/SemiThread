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

use \Mockery as m;



/**
 * @author Artur Augustyniak <artur@aaugustyniak.pl>
 */
class SemiThreadTest extends BaseTest
{

    const SEMI_THREAD_CLASS = 'Aaugustyniak\SemiThread\SemiThread',
        ENVELOPE_CLASS = 'Aaugustyniak\SemiThread\ConfinedEnvelope';

    private function getConfinedEnvelopeMock()
    {
        $methodIndicatingMock = array('popPayloadOnce' => ConfinedEnvelopeTest::CLONE_INDICATOR);
        $mock = m::mock(self::ENVELOPE_CLASS, $methodIndicatingMock);
        return $mock;
    }

    private function getAbstractClassMock()
    {
        $constructorArgs = array($this->getConfinedEnvelopeMock());
        $semiThread = $this->getMockForAbstractClass(self::SEMI_THREAD_CLASS, $constructorArgs);
        $semiThread->expects($this->never())
            ->method('run')
            ->will($this->returnValue(null));
        return $semiThread;
    }

    /**
     * @expectedException Aaugustyniak\SemiThread\Exception\PostMortemCall
     */
    public function testCanCallStartOnlyOnce()
    {
        $semiThread = $this->getAbstractClassMock();
        $semiThread->start();
        $semiThread->start();
    }

}
