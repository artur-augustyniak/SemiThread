<?php

namespace Aaugustyniak\SemiThread;

class ConfinedEnvelope {

    private $payload;

    /**
     * After constructor call clone of payload will be used
     * 
     * @param Clonable $payload
     */
    function __construct(Cloneable $payload) {
        $this->payload = $payload->getSelfClone();
    }

    /**
     * Allow to take payload only once
     * This force user to not use invalid reference
     * to confined value after copying value to another process.
     * 
     * @return Cloneable
     * @throws ConfinementViolation
     */
    function popPayloadOnce() {
        if (null === $this->payload) {
            throw new ConfineViolation();
        }
        $retVal = $this->payload;
        $this->payload = null;
        return $retVal;
    }

}
