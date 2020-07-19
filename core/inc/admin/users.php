<?php

    namespace App\Core;
    global $user;
    $this->data['users'] = $user->getAll();
    $this->data['user_count'] = is_array($this->data['users']) ? count($this->data['users']) : 0;

    $actlog = new actlog();
    $this->data['actlog'] = $actlog->show('admin/users') ;
