<?php

    namespace App\Core;
    global $user;

    $db = new MySQL(DB_INFO,'ipt_networks');
    $this->data['networks'] = $db->selectAll();

    foreach ($this->data['networks'] as $k => $network) {
        $this->data['networks'][$k]['server_flag'] = $db->selectRow('nid='.$network['server_nid'],null,'ipt_servers')['flag'];
    }