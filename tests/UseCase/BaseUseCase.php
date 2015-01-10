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
namespace Aaugustyniak\Tests\UseCase\SemiThread;


use Aaugustyniak\SemiThread\ExampleImpl\StringPayload;
use Aaugustyniak\SemiThread\ExampleImpl\WriterThread;
use Aaugustyniak\SemiThread\ConfinedEnvelope;
use Aaugustyniak\Tests\SemiThread\BaseTest;


/**
 * Example use case for SemiThread
 *
 * @author Artur Augustyniak <artur@aaugustyniak.pl>
 */
class BaseUseCase extends BaseTest
{

    public function testMain()
    {
        $payload = new StringPayload("This is Payload");
        $envelope = new ConfinedEnvelope($payload);
        $thread = new WriterThread($envelope);
        $thread->setOutput('semi_threads.out');
        $thread->start();
        echo "Main process output\n";
    }

}
