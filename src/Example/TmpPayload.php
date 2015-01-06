<?php
namespace Aaugustyniak\SemiThread\Example;
use Aaugustyniak\SemiThread\Cloneable;

class TmpPayload implements Cloneable {

    public $text = "This is Payload";

    public function getSelfClone() {
        return clone $this;
    }

}
