<?php

/**
 *
 * @author aaugustyniak
 */
interface Clonable {

    /**
     * Each object passed to async processing should be copied first.
     * Nohup tasks will accept only object implementing this interface
     * 
     * @return Clonable Sorry, you must implement reliable deep copy.
     */
    public function getSelfClone();
}
