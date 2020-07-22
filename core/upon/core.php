<?php

    namespace App\Core;

    function getUsernameByID ($id) {
        global $user;
        return $user->getUserbyID($id)['username'] ?? '-';
    }