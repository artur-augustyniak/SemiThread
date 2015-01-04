<?php

require_once './WriterThread.php';
require_once './ConfinedEnvelope.php';
require_once './TmpPayload.php';

for ($i = 0; $i < 2; $i++) {
    $payload = new TmpPayload();
    $env = new ConfinedEnvelope($payload);
    $thread = new WriterThread($env);
    $thread->run();
    
}

echo "Main Process\n";
