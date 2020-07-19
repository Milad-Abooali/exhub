<?php

    namespace App\Core;

    $actlog = new actlog();
    $this->data['actlog'] = $actlog->show(null,100);
