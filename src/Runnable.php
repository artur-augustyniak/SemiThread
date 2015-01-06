<?php

namespace Aaugustyniak\SemiThread;

/**
 *
 * @author aaugustyniak
 */
abstract class Runnable {

    const FS_RUNNER_NAME = 'FsRunner.php';

    private $id;
    private $valid = true;

    /**
     * @todo windows black-hole?
     */
    private $output = '/dev/null';
    private $serializationArea;
    private $runnerPath;
    protected $payload;

    public function setOutput($output) {
        $this->output = $output;
    }

    function setSerializationArea($serializationArea) {
        $this->serializationArea = $serializationArea;
    }

    function __construct(ConfinedEnvelope $envelope) {
        $this->serializationArea = \sys_get_temp_dir();
        $this->runnerPath = realpath(__DIR__ .
                DIRECTORY_SEPARATOR .
                self::FS_RUNNER_NAME);
        $this->id = uniqid();
        $this->payload = $envelope->popPayloadOnce();
    }

    public abstract function run();

    /**
     * yup, thread run
     */
    public function start() {
        if ($this->valid) {
            $this->valid = false;
            $serializedThis = serialize($this);
            file_put_contents(
                    $this->serializationArea .
                    DIRECTORY_SEPARATOR .
                    $this->id, $serializedThis
            );
            $command = sprintf("nohup php %s %s %s >> %s 2>&1 &", 
                    $this->runnerPath, 
                    $this->id, 
                    $this->serializationArea, 
                    $this->output);
            exec($command);
        } else {
            throw new PostMortemCall();
        }
    }

}
