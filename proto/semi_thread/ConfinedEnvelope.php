<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UnsettingEnvelope
 *
 * @author aaugustyniak
 */
class ConfinementViolation extends Exception {

    function __construct() {
        $this->message = "Trying to use value possibly confined to thread";
    }

}

class ConfinedEnvelope {

    private $payload;

    /**
     * Each value passed here will be eventualy destroyed even in outer scope
     * 
     * @param Clonable $payload
     */
    function __construct(Clonable $payload) {
        $this->payload = $payload;
    }

    function popPayload() {
        if (null === $this->payload) {
            throw new ConfinementViolation();
        }
        $retVal = clone $this->payload;
        unset($GLOBALS['payload']);
        $this->payload = null;

        return $retVal;
    }

}
