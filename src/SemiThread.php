<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Artur Augustyniak
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Aaugustyniak\SemiThread;

use Aaugustyniak\SemiThread\Exception\ConfineViolation;
use Aaugustyniak\SemiThread\Exception\PostMortemCall;

/**
 * Main fuzz
 * Base SemiThread wiring
 *
 * @author Artur Augustyniak <artur@aaugustyniak.pl>
 */
abstract class SemiThread
{

    const FS_RUNNER_NAME = 'FsRunner.php';

    /**
     * @var bool
     */
    private $devMode = false;

    /**
     * @var string file name for object transport
     */
    private $id;
    /**
     * @var bool single start use indicator
     */
    private $valid = true;
    /**
     * @var string thread output redirection path
     */
    private $output = '/dev/null';

    /**
     * @var string serialized threads tmp folder
     */
    private $serializationArea;
    /**
     * @var string path to simple script for call run on unserialized SemiThread object
     */
    private $runnerPath;

    /**
     * Thread data
     *
     * @var
     */
    protected $payload;

    /**
     * @param ConfinedEnvelope $envelope
     * @throws ConfineViolation
     */
    function __construct(ConfinedEnvelope $envelope)
    {
        $this->serializationArea = \sys_get_temp_dir();
        $this->runnerPath = realpath(__DIR__ .
            DIRECTORY_SEPARATOR .
            self::FS_RUNNER_NAME);
        $this->id = uniqid();
        $this->payload = $envelope->popPayloadOnce();
        $this->setMode();
    }


    private function setMode()
    {
        $this->devMode = true;
    }

    /**
     * User defined method.
     * Job to be done in SemiThread
     *
     * @return void
     */
    public abstract function run();


    /**
     * Redirect thread output to given file
     * @param $output output file path
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * Set custom localization of serialized SemiThread objects
     * Default is system tmp
     *
     * @param $serializationArea folder path
     */
    function setSerializationArea($serializationArea)
    {
        $this->serializationArea = $serializationArea;
    }

    /**
     * SemiThread start.
     * Kind of no-return point
     * THIS CALL IS NON-BLOCKING
     *
     * @throws PostMortemCall
     */
    public function start()
    {
        if ($this->valid) {
            $this->valid = false;
            $serializedThis = serialize($this);
            file_put_contents(
                $this->serializationArea .
                DIRECTORY_SEPARATOR .
                $this->id, $serializedThis
            );
            $command = sprintf("nohup php %s %s %s %s >> %s 2>&1 &", $this->runnerPath, $this->id, $this->serializationArea, (int) $this->devMode, $this->output);

            exec($command);
        } else {
            throw new PostMortemCall();
        }
    }

}
