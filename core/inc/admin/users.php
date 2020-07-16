<?php

    namespace App\Core;

    global $user;

    if ($_POST) {
        $this->data['add_user'] = $user->add($_POST);
    }