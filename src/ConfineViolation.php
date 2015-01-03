<?php

namespace Aaugustyniak\SemiThread;

/**
 * Description of ConfineViolation
 *
 * @author aaugustyniak
 */
class ConfineViolation extends \Exception {

    function __construct() {
        $this->message = "Trying to use value possibly confined to thread";
    }

}
