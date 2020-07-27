<?php

    namespace App\Core;
    global $user;

    $db = new MySQL(DB_INFO,'ipt_servers');
    $this->data['servers'] = $db->selectAll(null,'nid');
    $this->data['servers_count'] = is_array($this->data['servers']) ? count($this->data['servers']) : 0;
