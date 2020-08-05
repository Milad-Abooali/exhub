<?php

    namespace App\Core;
    global $user;

    $db = new MySQL(DB_INFO,'ipt_ips');
    $this->data['ips'] = $db->selectAll();

    if ($this->data['ips']) {
        foreach ($this->data['ips'] as $k => $ip) {
            $this->data['ips'][$k]['network'] = $db->selectId($ip['network_id'],'*','ipt_networks');
            $where = 'nid='.$this->data['ips'][$k]['network']['server_nid'];
            $this->data['ips'][$k]['server'] = $db->selectRow($where,null,'ipt_servers');
        }
    }