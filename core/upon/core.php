<?php

    namespace App\Core;

    function userId ($id) {
        global $user;
        return $user->getUserbyID($id);
    }