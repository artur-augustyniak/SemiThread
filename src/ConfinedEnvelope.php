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
namespace Aaugustyniak\SemiThread;
use Aaugustyniak\SemiThread\Exception\ConfineViolation;

/**
 * Contract for data to be sent to SemiThread env
 * Data confined to SemiThread should not be used after non blocking call
 *
 * @author Artur Augustyniak <artur@aaugustyniak.pl>
 */
class ConfinedEnvelope
{

    /**
     * @var Cloneable
     */
    private $payload;

    /**
     * After constructor call clone of payload will be used
     *
     * @param Cloneable $payload
     */
    function __construct(Cloneable $payload)
    {
        $this->payload = $payload->getSelfClone();
    }

    /**
     * Allow to take payload only once.
     * This force user not to use invalid reference after copying value to another process.
     *
     * @return Cloneable
     * @throws ConfineViolation
     */
    function popPayloadOnce()
    {
        if (null === $this->payload) {
            throw new ConfineViolation();
        }
        $retVal = $this->payload;
        $this->payload = null;
        return $retVal;
    }

}
