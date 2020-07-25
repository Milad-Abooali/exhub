<?php

    namespace App\Core;
    global $user;
    $this->data['users'] = $user->getAll();
    $this->data['user_count'] = is_array($this->data['users']) ? count($this->data['users']) : 0;
