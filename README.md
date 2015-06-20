[![Build Status](https://travis-ci.org/artur-augustyniak/SemiThread.svg?branch=master)](https://travis-ci.org/artur-augustyniak/SemiThread)
# Simple API for starting non blocking jobs.

# SemiThread

Right now this stuff works only under *nix systems.
It's simple wrapper API for nohup exec call.

If you want i.e. send an email in process not attached to request/response cycle it is for you.

## Installation 

If you don’t have Composer yet, you should [get it](http://getcomposer.org) now.

1. Add the package to your `composer.json`:

        "require": {
          ...
          "aaugustyniak/semithread": "1.0.0",
          ...
        }

2. Install:

        $ php composer.phar install

3. And use:

First of all You must provide your implementations of:
* Aaugustyniak\SemiThread\Cloneable
* Aaugustyniak\SemiThread\SemiThread

examples are provided in Aaugustyniak\SemiThread\ExampleImpl.
```php
		<?php 
		
		require_once "vendor/autoload.php";
		
		$payload = new StringPayload("This is Payload");
        $envelope = new ConfinedEnvelope($payload);
        $thread = new WriterThread($envelope);
        /**
         * Optional, redirect jobs output to file 
         */ 
        $thread->setOutput('/some/path/semi_threads.out');
        $thread->start();
        echo "Main process output\n";
		...
	
