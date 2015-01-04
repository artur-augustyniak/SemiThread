<?php
require_once './Clonable.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TmpPayload
 *
 * @author aaugustyniak
 */
class TmpPayload implements Clonable {
    
    public $text = "sdf";

    public function getSelfClone() {
        return clone $this;
    }

//put your code here
}
