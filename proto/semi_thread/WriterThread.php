<?php

require_once './Runnable.php';
require_once './TmpPayload.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WriterThread
 *
 * @author aaugustyniak
 */
class WriterThread extends Runnable {

    public function __construct(ConfinedEnvelope $envelope) {
        parent::__construct($envelope);
    }

    public function work() {
        sleep(1);
        echo "object TmpPayload " . $this->payload->text . "\n";
    }

}
