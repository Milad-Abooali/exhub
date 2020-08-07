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

    $this->data['status_text'] = [
      0 =>  'Reserved',
      1 =>  'Free',
      2 =>  'rVPS',
      3 =>  'Main',
      4 =>  'Extra',
      5 =>  'CB',
      6 =>  'Pended'
    ];

    $this->data['status_color'] = [
      0 =>  'muted',
      1 =>  'success',
      2 =>  'info',
      3 =>  'primary',
      4 =>  'primary',
      5 =>  'warning',
      6 =>  'danger'
    ];