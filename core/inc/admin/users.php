<?php

    namespace App\Core;
    global $user;
    $this->data['users'] = $user->getAll();
