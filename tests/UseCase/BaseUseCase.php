<?php

namespace Aaugustyniak\Tests\UseCase\SemiThread;

use \Mockery as m;
use \PHPUnit_Framework_TestCase as TestCase;
use Aaugustyniak\SemiThread\ConfinedEnvelope;

class TmpPayload implements \Aaugustyniak\SemiThread\Cloneable {
    
    public $text = "sdf";

    public function getSelfClone() {
        return clone $this;
    }

//put your code here
}

/**
 * Description of BaseUseCase
 *
 * @author aaugustyniak
 */
class BaseUseCase extends TestCase {

    public function testMain() {
        for ($i = 0; $i < 2; $i++) {
            $payload = new TmpPayload();
            $env = new ConfinedEnvelope($payload);
            $thread = new WriterThread($env);
            $thread->run();
        }
        echo "Main Process\n";
    }

}
