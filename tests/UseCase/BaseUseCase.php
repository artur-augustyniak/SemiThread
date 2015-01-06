<?php

namespace Aaugustyniak\Tests\UseCase\SemiThread;

use \PHPUnit_Framework_TestCase as TestCase;
use Aaugustyniak\SemiThread\ConfinedEnvelope;
use Aaugustyniak\SemiThread\Example\WriterThread;
use Aaugustyniak\SemiThread\Example\TmpPayload;

/**
 * Description of BaseUseCase
 *
 * @author aaugustyniak
 */
class BaseUseCase extends TestCase {

    public function testMain() {
        $payload = new TmpPayload();
        $env = new ConfinedEnvelope($payload);
        $thread = new WriterThread($env);
        $thread->setOutput('out');
        $thread->start();
        echo "Main Process\n";
    }

}
