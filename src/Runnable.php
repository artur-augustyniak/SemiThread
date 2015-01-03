<?php

namespace Aaugustyniak\SemiThread;

/**
 *
 * @author aaugustyniak
 */
abstract class Runnable {

    private $id;
    private $valid = true;
    protected $payload;

    function __construct(ConfinedEnvelope $envelope) {
        $this->id = uniqid();
        $this->payload = $envelope->popPayload();
    }

    public abstract function work();

    /**
     * yup, thread run
     */
    public function run() {
        if ($this->valid) {
            $this->valid = false;
            $s = serialize($this);
            file_put_contents("/tmp/" . $this->id, $s);
            //$out = '/dev/null';
            $out = 'out';
            exec("nohup php NohupRunner.php " . $this->id . "  >> " . $out . " 2>&1 &");
        } else {
            throw new PostMortemCall();
        }
    }

}
