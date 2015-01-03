<?php

namespace Aaugustyniak\SemiThread;

class PostMortemCall extends \Exception {

    function __construct() {
        $this->message = "Trying to call run() 2nd time";
    }

}
