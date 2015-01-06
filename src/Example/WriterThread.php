<?php

namespace Aaugustyniak\SemiThread\Example;

use Aaugustyniak\SemiThread\Runnable;
use Aaugustyniak\SemiThread\ConfinedEnvelope;

/**
 * Description of WriterThread
 *
 * @author aaugustyniak
 */
class WriterThread extends Runnable {

    public function __construct(ConfinedEnvelope $envelope) {
        parent::__construct($envelope);
    }

    public function run() {
        sleep(1);
        echo "object TmpPayload " . $this->payload->text . "\n";
    }

}
