<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templatesimplements Runnable 
 * and open the template in the editor.
 */

/**
 * Description of NohupProcess
 *
 * @author aaugustyniak
 */
class NohupProcess {

    private $id;
    private $runnable;

    function __construct(Runnable $runnable) {
        $this->id = uniqid();
        $this->runnable = $runnable;
    }

    public function start() {
        $s = serialize($this);
        file_put_contents("/tmp/" . $this->id, $s);
        //$out = '/dev/null';
        $out = 'out';
        exec("nohup php NohupRunner.php " . $this->id . "  >> " . $out . " 2>&1 &");
    }

    public function doJob() {
        sleep(1);
        echo "object " . $this->runnable->text . "\n";
//        foreach ($this->payload as $k => $v) {
//            echo sprintf("%s - %s\n", $k, $v->getText());
//        }
    }

    public function __toString() {
        return "NohupProcess id:" . $this->id;
    }

}
