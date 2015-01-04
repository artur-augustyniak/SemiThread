<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SomeObject
 *
 * @author aaugustyniak
 */
class SomeObject {
    
    public $dynamicPart = "bla";

    public function getText() {
        return "SomeObject ".$this->dynamicPart;
    }

}
