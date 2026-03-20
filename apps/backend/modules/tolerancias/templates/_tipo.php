<?php

// echo ToleranciaPeer::$tipos[$Tolerancia->getTipo()];
echo __(sfInflector::humanize(ToleranciaPeer::$campos[$Tolerancia->getTipo()]), array(), 'messages');